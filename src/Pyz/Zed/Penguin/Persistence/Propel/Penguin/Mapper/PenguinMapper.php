<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Persistence\Propel\Penguin\Mapper;

use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;
use Generated\Shared\Transfer\PenguinCollectionTransfer;
use Generated\Shared\Transfer\PenguinTransfer;
use Orm\Zed\Penguin\Persistence\SpyPenguin;
use Propel\Runtime\Collection\ObjectCollection;

class PenguinMapper
{
    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     * @param \Orm\Zed\Penguin\Persistence\SpyPenguin $penguinEntity
     *
     * @return \Orm\Zed\Penguin\Persistence\SpyPenguin
     */
    public function mapPenguinTransferToPenguinEntity(PenguinTransfer $penguinTransfer, SpyPenguin $penguinEntity): SpyPenguin
    {
        return $penguinEntity->fromArray($penguinTransfer->modifiedToArray());
    }

    /**
     * @param \Orm\Zed\Penguin\Persistence\SpyPenguin $penguinEntity
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function mapPenguinEntityToPenguinTransfer(SpyPenguin $penguinEntity, PenguinTransfer $penguinTransfer): PenguinTransfer
    {
        return $penguinTransfer->fromArray($penguinEntity->toArray(), true);
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection|\Orm\Zed\Penguin\Persistence\SpyPenguin[] $penguinEntityCollection
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function mapPenguinEntityCollectionToPenguinCollectionResponseTransfer(
        ObjectCollection $penguinEntityCollection,
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
    ): PenguinCollectionResponseTransfer {
        foreach ($penguinEntityCollection as $penguinEntity) {
            $penguinCollectionResponseTransfer->addPenguin($this->mapPenguinEntityToPenguinTransfer($penguinEntity, new PenguinTransfer()));
        }

        return $penguinCollectionResponseTransfer;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection|\Orm\Zed\Penguin\Persistence\SpyPenguin[] $penguinEntityCollection
     * @param \Generated\Shared\Transfer\PenguinCollectionTransfer $penguinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionTransfer
     */
    public function mapPenguinEntityCollectionToPenguinCollectionTransfer(
        ObjectCollection $penguinEntityCollection,
        PenguinCollectionTransfer $penguinCollectionTransfer,
    ): PenguinCollectionTransfer {
        foreach ($penguinEntityCollection as $penguinEntity) {
            $penguinCollectionTransfer->addPenguin($this->mapPenguinEntityToPenguinTransfer($penguinEntity, new PenguinTransfer()));
        }

        return $penguinCollectionTransfer;
    }
}
