<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business\Penguin\Writer;

use ArrayObject;
use Generated\Shared\Transfer\ErrorTransfer;
use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;
use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;
use Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder\PenguinIdentifierBuilderInterface;
use Pyz\Zed\Penguin\Business\Penguin\Validator\PenguinValidatorInterface;
use Pyz\Zed\Penguin\Persistence\PenguinEntityManagerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class PenguinUpdater implements PenguinUpdaterInterface
{
    use TransactionTrait;

    /**
     * @var \Pyz\Zed\Penguin\Persistence\PenguinEntityManagerInterface
     */
    protected PenguinEntityManagerInterface $penguinEntityManager;

    /**
     * @var \Pyz\Zed\Penguin\Business\Penguin\Validator\PenguinValidatorInterface
     */
    protected PenguinValidatorInterface $penguinValidator;

    /**
     * @var \Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder\PenguinIdentifierBuilderInterface
     */
    protected PenguinIdentifierBuilderInterface $penguinIdentifierBuilder;

    /**
     * @var \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface[]
     */
    protected array $penguinPreUpdatePlugins;

    /**
     * @var \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface[]
     */
    protected array $penguinPostUpdatePlugins;

    /**
     * @param \Pyz\Zed\Penguin\Persistence\PenguinEntityManagerInterface $penguinEntityManager
     * @param \Pyz\Zed\Penguin\Business\Penguin\Validator\PenguinValidatorInterface $penguinValidator
     * @param \Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder\PenguinIdentifierBuilderInterface $penguinIdentifierBuilder
     * @param \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface[] $penguinPreUpdatePlugins
     * @param \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface[] $penguinPostUpdatePlugins
     */
    public function __construct(
        PenguinEntityManagerInterface $penguinEntityManager,
        PenguinValidatorInterface $penguinValidator,
        PenguinIdentifierBuilderInterface $penguinIdentifierBuilder,
        array $penguinPreUpdatePlugins,
        array $penguinPostUpdatePlugins,
    ) {
        $this->penguinEntityManager = $penguinEntityManager;
        $this->penguinValidator = $penguinValidator;
        $this->penguinIdentifierBuilder = $penguinIdentifierBuilder;
        $this->penguinPreUpdatePlugins = $penguinPreUpdatePlugins;
        $this->penguinPostUpdatePlugins = $penguinPostUpdatePlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function updatePenguinCollection(
        PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer,
    ): PenguinCollectionResponseTransfer {
        $penguinCollectionResponseTransfer = new PenguinCollectionResponseTransfer();
        $penguinCollectionResponseTransfer->setPenguins($penguinCollectionRequestTransfer->getPenguins());

        $penguinCollectionResponseTransfer = $this->penguinValidator->validateCollection($penguinCollectionResponseTransfer);

        if ($penguinCollectionRequestTransfer->getIsTransactional() && $penguinCollectionResponseTransfer->getErrors()->count()) {
            return $penguinCollectionResponseTransfer;
        }

        $penguinCollectionResponseTransfer = $this->filterInvalidPenguins($penguinCollectionResponseTransfer);

        // This will save all entities in one transaction. If any of the entities in the collection fails to be persisted
        // it will roll all of them back. And we don't catch exceptions here intentionally!
        return $this->getTransactionHandler()->handleTransaction(function () use ($penguinCollectionResponseTransfer) {
            return $this->executeUpdatePenguinCollectionResponseTransaction($penguinCollectionResponseTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    protected function filterInvalidPenguins(
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
    ): PenguinCollectionResponseTransfer {
        $penguinIdsWithErrors = $this->getPenguinIdsWithErrors($penguinCollectionResponseTransfer->getErrors());

        $penguinTransfers = $penguinCollectionResponseTransfer->getPenguins();
        $penguinCollectionResponseTransfer->setPenguins(new ArrayObject());

        foreach ($penguinTransfers as $penguinTransfer) {
            // Check each SINGLE item before it is saved for errors, if it has some continue with the next one.
            if (!in_array($this->penguinIdentifierBuilder->buildIdentifier($penguinTransfer), $penguinIdsWithErrors, true)) {
                $penguinCollectionResponseTransfer->addPenguin($penguinTransfer);
            }
        }

        return $penguinCollectionResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    protected function executeUpdatePenguinCollectionResponseTransaction(
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
    ): PenguinCollectionResponseTransfer {
        // Run pre-save plugins
        $penguinTransfers = $this->executePenguinPreUpdatePlugins($penguinCollectionResponseTransfer->getPenguins()->getArrayCopy());

        $persistedPenguinTransfers = [];

        foreach ($penguinTransfers as $penguinTransfer) {
            $persistedPenguinTransfers[] = $this->penguinEntityManager->updatePenguin($penguinTransfer);
        }

        // Run post-save plugins
        $persistedPenguinTransfers = $this->executePenguinPostUpdatePlugins($persistedPenguinTransfers);

        $penguinCollectionResponseTransfer->setPenguins(new ArrayObject($persistedPenguinTransfers));

        return $penguinCollectionResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer[] $penguinTransfers
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer[]
     */
    protected function executePenguinPreUpdatePlugins(
        array $penguinTransfers,
    ): array {
        foreach ($this->penguinPreUpdatePlugins as $penguinPreUpdatePlugin) {
            $penguinTransfers = $penguinPreUpdatePlugin->execute($penguinTransfers);
        }

        return $penguinTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer[] $penguinTransfers
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer[]
     */
    protected function executePenguinPostUpdatePlugins(
        array $penguinTransfers,
    ): array {
        foreach ($this->penguinPostUpdatePlugins as $penguinPostUpdatePlugin) {
            $penguinTransfers = $penguinPostUpdatePlugin->execute($penguinTransfers);
        }

        return $penguinTransfers;
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\ErrorTransfer[] $errorTransfers
     *
     * @return string[]
     */
    protected function getPenguinIdsWithErrors(ArrayObject $errorTransfers): array
    {
        return array_unique(array_map(static function (ErrorTransfer $errorTransfer): ?string {
            return $errorTransfer->getEntityIdentifier();
        }, $errorTransfers->getArrayCopy()));
    }
}