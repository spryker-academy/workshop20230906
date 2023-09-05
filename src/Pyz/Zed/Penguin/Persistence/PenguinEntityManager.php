<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Persistence;

use Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\PenguinTransfer;
use Orm\Zed\Penguin\Persistence\SpyPenguin;
use Orm\Zed\Penguin\Persistence\SpyPenguinQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\Penguin\Persistence\PenguinPersistenceFactory getFactory()
 */
class PenguinEntityManager extends AbstractEntityManager implements PenguinEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function createPenguin(PenguinTransfer $penguinTransfer): PenguinTransfer
    {
        $penguinEntity = $this->getFactory()->createPenguinMapper()->mapPenguinTransferToPenguinEntity($penguinTransfer, new SpyPenguin());
        $penguinEntity->save();

        return $this->getFactory()->createPenguinMapper()->mapPenguinEntityToPenguinTransfer($penguinEntity, $penguinTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function updatePenguin(PenguinTransfer $penguinTransfer): PenguinTransfer
    {
        $penguinEntity = $this->getFactory()->createPenguinQuery()->filterByIdPenguin($penguinTransfer->getIdPenguinOrFail())->findOne();
        $penguinMapper = $this->getFactory()->createPenguinMapper();
        $penguinEntity = $penguinMapper->mapPenguinTransferToPenguinEntity($penguinTransfer, $penguinEntity);
        $penguinEntity->save();

        return $penguinMapper->mapPenguinEntityToPenguinTransfer($penguinEntity, $penguinTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function deletePenguin(PenguinTransfer $penguinTransfer): PenguinTransfer
    {
        $penguinEntity = $this->getFactory()->createPenguinQuery()->filterByIdPenguin($penguinTransfer->getIdPenguinOrFail())->findOne();
        $penguinMapper = $this->getFactory()->createPenguinMapper();
        $penguinEntity = $penguinMapper->mapPenguinTransferToPenguinEntity($penguinTransfer, $penguinEntity);
        $penguinEntity->delete();

        return $penguinMapper->mapPenguinEntityToPenguinTransfer($penguinEntity, $penguinTransfer);
    }

    /**
     * @param \Orm\Zed\Penguin\Persistence\SpyPenguinQuery $penguinQuery
     * @param \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer
     *
     * @return \Orm\Zed\Penguin\Persistence\SpyPenguinQuery
     */
    protected function applyPenguinDeleteFilters(
        SpyPenguinQuery $penguinQuery,
        PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer,
    ): SpyPenguinQuery {
        if ($penguinCollectionDeleteCriteriaTransfer->getPenguinIds()) {
            $penguinQuery->filterByIdPenguin($penguinCollectionDeleteCriteriaTransfer->getPenguinIds(), Criteria::IN);
        }
        if ($penguinCollectionDeleteCriteriaTransfer->getUuids()) {
            $penguinQuery->filterByUuid($penguinCollectionDeleteCriteriaTransfer->getUuids(), Criteria::IN);
        }

        return $penguinQuery;
    }
}
