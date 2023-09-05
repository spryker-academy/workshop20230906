<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Persistence;

use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\PenguinCollectionTransfer;
use Generated\Shared\Transfer\PenguinCriteriaTransfer;
use Orm\Zed\Penguin\Persistence\SpyPenguinQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\Penguin\Persistence\PenguinPersistenceFactory getFactory()
 */
class PenguinRepository extends AbstractRepository implements PenguinRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\PenguinCriteriaTransfer $penguinCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionTransfer
     */
    public function getPenguinCollection(
        PenguinCriteriaTransfer $penguinCriteriaTransfer,
    ): PenguinCollectionTransfer {
        $penguinCollectionTransfer = new PenguinCollectionTransfer();
        $penguinQuery = $this->getFactory()->createPenguinQuery();
        // Filter
        $penguinQuery = $this->applyPenguinFilters($penguinQuery, $penguinCriteriaTransfer);
        // Sort
        $penguinQuery = $this->applyPenguinSorting($penguinQuery, $penguinCriteriaTransfer);
        // Paginate only if the transfer is present
        $paginationTransfer = $penguinCriteriaTransfer->getPagination();
        if ($paginationTransfer !== null) {
            $penguinQuery = $this->applyPenguinPagination($penguinQuery, $paginationTransfer);
            $penguinCollectionTransfer->setPagination($paginationTransfer);
        }
        $objectCollection = $penguinQuery->find();

        return $this->getFactory()->createPenguinMapper()->mapPenguinEntityCollectionToPenguinCollectionTransfer($objectCollection, $penguinCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionTransfer
     */
    public function getPenguinDeleteCollection(
        PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer,
    ): PenguinCollectionTransfer {
        $penguinCollectionTransfer = new PenguinCollectionTransfer();
        $penguinQuery = $this->getFactory()->createPenguinQuery();
        $penguinEntities = $this->applyPenguinDeleteFilters($penguinQuery, $penguinCollectionDeleteCriteriaTransfer)->find();
        if (!$penguinEntities->count()) {
            return $penguinCollectionTransfer;
        }

        return $this->getFactory()->createPenguinMapper()->mapPenguinEntityCollectionToPenguinCollectionTransfer($penguinEntities, $penguinCollectionTransfer);
    }

    /**
     * @param \Orm\Zed\Penguin\Persistence\SpyPenguinQuery $penguinQuery
     * @param \Generated\Shared\Transfer\PenguinCriteriaTransfer $penguinCriteriaTransfer
     *
     * @return \Orm\Zed\Penguin\Persistence\SpyPenguinQuery
     */
    protected function applyPenguinFilters(
        SpyPenguinQuery $penguinQuery,
        PenguinCriteriaTransfer $penguinCriteriaTransfer,
    ): SpyPenguinQuery {
        $penguinConditionsTransfer = $penguinCriteriaTransfer->getPenguinConditions();
        if ($penguinConditionsTransfer === null) {
            return $penguinQuery;
        }

        return $this->buildQueryByConditions($penguinConditionsTransfer->modifiedToArray(), $penguinQuery);
    }

    /**
     * @param \Orm\Zed\Penguin\Persistence\SpyPenguinQuery $penguinQuery
     * @param \Generated\Shared\Transfer\PaginationTransfer $paginationTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected function applyPenguinPagination(
        SpyPenguinQuery $penguinQuery,
        PaginationTransfer $paginationTransfer,
    ): ModelCriteria {
        if ($paginationTransfer->getOffset() !== null || $paginationTransfer->getLimit() !== null) {
            $penguinQuery->offset($paginationTransfer->getOffsetOrFail())->setLimit($paginationTransfer->getLimitOrFail());

            return $penguinQuery;
        }
        $paginationModel = $penguinQuery->paginate($paginationTransfer->getPageOrFail(), $paginationTransfer->getMaxPerPageOrFail());
        $paginationTransfer->setNbResults($paginationModel->getNbResults())->setFirstIndex($paginationModel->getFirstIndex())->setLastIndex($paginationModel->getLastIndex())->setFirstPage($paginationModel->getFirstPage())->setLastPage($paginationModel->getLastPage())->setNextPage($paginationModel->getNextPage())->setPreviousPage($paginationModel->getPreviousPage());

        // Map the propel pagination model data to the transfer as needed
        return $paginationModel->getQuery();
    }

    /**
     * @param \Orm\Zed\Penguin\Persistence\SpyPenguinQuery $penguinQuery
     * @param \Generated\Shared\Transfer\PenguinCriteriaTransfer $penguinCriteriaTransfer
     *
     * @return \Orm\Zed\Penguin\Persistence\SpyPenguinQuery
     */
    protected function applyPenguinSorting(SpyPenguinQuery $penguinQuery, PenguinCriteriaTransfer $penguinCriteriaTransfer): SpyPenguinQuery
    {
        $sortCollection = $penguinCriteriaTransfer->getSortCollection();
        foreach ($sortCollection as $sortTransfer) {
            $penguinQuery->orderBy($sortTransfer->getField(), $sortTransfer->getIsAscending() ? Criteria::ASC : Criteria::DESC);
        }

        return $penguinQuery;
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
        return $this->buildQueryByConditions($penguinCollectionDeleteCriteriaTransfer->modifiedToArray(), $penguinQuery);
    }

    /**
     * @param array $conditions
     * @param \Orm\Zed\Penguin\Persistence\SpyPenguinQuery $penguinQuery
     *
     * @return \Orm\Zed\Penguin\Persistence\SpyPenguinQuery
     */
    protected function buildQueryByConditions(array $conditions, SpyPenguinQuery $penguinQuery): SpyPenguinQuery
    {
        if (isset($conditions['penguin_ids'])) {
            $penguinQuery->filterByIdPenguin($conditions['penguin_ids'], Criteria::IN);
        }
        if (isset($conditions['uuids'])) {
            $penguinQuery->filterByUuid($conditions['uuids'], Criteria::IN);
        }

        return $penguinQuery;
    }
}
