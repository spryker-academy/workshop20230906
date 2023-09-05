<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business\Penguin\Reader;

use ArrayObject;
use Generated\Shared\Transfer\PenguinCollectionTransfer;
use Generated\Shared\Transfer\PenguinCriteriaTransfer;
use Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface;

class PenguinReader implements PenguinReaderInterface
{
    /**
     * @var \Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface
     */
    protected PenguinRepositoryInterface $penguinRepository;

    /**
     * @var \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Expander\PenguinExpanderPluginInterface[]
     */
    protected array $penguinExpanderPlugins;

    /**
     * @param \Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface $penguinRepository
     * @param \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Expander\PenguinExpanderPluginInterface[] $penguinExpanderPlugins
     */
    public function __construct(
        PenguinRepositoryInterface $penguinRepository,
        array $penguinExpanderPlugins,
    ) {
        $this->penguinRepository = $penguinRepository;
        $this->penguinExpanderPlugins = $penguinExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCriteriaTransfer $penguinCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionTransfer
     */
    public function getPenguinCollection(
        PenguinCriteriaTransfer $penguinCriteriaTransfer,
    ): PenguinCollectionTransfer {
        $penguinCollectionTransfer = $this->penguinRepository
            ->getPenguinCollection($penguinCriteriaTransfer);

        return $this->executePenguinExpanderPlugins($penguinCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionTransfer $penguinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionTransfer
     */
    protected function executePenguinExpanderPlugins(
        PenguinCollectionTransfer $penguinCollectionTransfer,
    ): PenguinCollectionTransfer {
        $penguinTransfers = $penguinCollectionTransfer->getPenguins()->getArrayCopy();

        foreach ($this->penguinExpanderPlugins as $penguinExpanderPlugin) {
            $penguinTransfers = $penguinExpanderPlugin->expand($penguinTransfers);
        }

        return $penguinCollectionTransfer->setPenguins(new ArrayObject($penguinTransfers));
    }
}
