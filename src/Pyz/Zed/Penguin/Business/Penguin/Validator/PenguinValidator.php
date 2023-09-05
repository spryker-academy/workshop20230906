<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business\Penguin\Validator;

use Generated\Shared\Transfer\ErrorTransfer;
use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;
use Generated\Shared\Transfer\PenguinTransfer;
use Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder\PenguinIdentifierBuilderInterface;

class PenguinValidator implements PenguinValidatorInterface
{
    /**
     * @var \Pyz\Zed\Penguin\Business\Penguin\Validator\Rules\PenguinValidatorRuleInterface[]
     */
    protected array $validatorRules = [];

    /**
     * @var \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Validator\PenguinValidatorRulePluginInterface[]
     */
    protected array $validatorRulePlugins = [];

    /**
     * @var \Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder\PenguinIdentifierBuilderInterface
     */
    protected PenguinIdentifierBuilderInterface $identifierBuilder;

    /**
     * @param \Pyz\Zed\Penguin\Business\Penguin\Validator\Rules\PenguinValidatorRuleInterface[] $validatorRules
     * @param \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Validator\PenguinValidatorRulePluginInterface[] $validatorRulePlugins
     * @param \Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder\PenguinIdentifierBuilderInterface $identifierBuilder
     */
    public function __construct(
        array $validatorRules,
        array $validatorRulePlugins,
        PenguinIdentifierBuilderInterface $identifierBuilder,
    ) {
        $this->validatorRules = $validatorRules;
        $this->validatorRulePlugins = $validatorRulePlugins;
        $this->identifierBuilder = $identifierBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function validateCollection(
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
    ): PenguinCollectionResponseTransfer {
        foreach ($penguinCollectionResponseTransfer->getPenguins() as $penguinTransfer) {
            $penguinCollectionResponseTransfer = $this->validate($penguinTransfer, $penguinCollectionResponseTransfer);
        }

        return $penguinCollectionResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function validate(
        PenguinTransfer $penguinTransfer,
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
    ): PenguinCollectionResponseTransfer {
        $penguinCollectionResponseTransfer = $this->executeValidatorRules($penguinTransfer, $penguinCollectionResponseTransfer);
        $penguinCollectionResponseTransfer = $this->executeValidatorRulePlugins($penguinTransfer, $penguinCollectionResponseTransfer);

        return $penguinCollectionResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    protected function executeValidatorRules(
        PenguinTransfer $penguinTransfer,
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
    ): PenguinCollectionResponseTransfer {
        foreach ($this->validatorRules as $validatorRule) {
            $errors = $validatorRule->validate($penguinTransfer);

            $penguinCollectionResponseTransfer = $this->addErrorsToCollectionResponseTransfer($penguinTransfer, $penguinCollectionResponseTransfer, $errors);
        }

        return $penguinCollectionResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    protected function executeValidatorRulePlugins(
        PenguinTransfer $penguinTransfer,
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
    ): PenguinCollectionResponseTransfer {
        foreach ($this->validatorRulePlugins as $validatorRule) {
            $errors = $validatorRule->validate($penguinTransfer);

            $penguinCollectionResponseTransfer = $this->addErrorsToCollectionResponseTransfer($penguinTransfer, $penguinCollectionResponseTransfer, $errors);
        }

        return $penguinCollectionResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     * @param string[] $errors
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    protected function addErrorsToCollectionResponseTransfer(
        PenguinTransfer $penguinTransfer,
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
        array $errors,
    ): PenguinCollectionResponseTransfer {
        $identifier = $this->identifierBuilder->buildIdentifier($penguinTransfer);

        foreach ($errors as $error) {
            $penguinCollectionResponseTransfer->addError(
                (new ErrorTransfer())
                    ->setMessage($error)
                    ->setEntityIdentifier($identifier),
            );
        }

        return $penguinCollectionResponseTransfer;
    }
}
