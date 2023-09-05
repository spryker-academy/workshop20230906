<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business;

use Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;
use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;
use Generated\Shared\Transfer\PenguinCollectionTransfer;
use Generated\Shared\Transfer\PenguinCriteriaTransfer;

interface PenguinFacadeInterface
{
    /**
     * Specification:
     * - Fetches collection of Penguins from the storage.
     * - Uses `PenguinCriteriaTransfer.PenguinConditions.penguinIds` to filter penguins by penguinIds.
     * - Uses `PenguinCriteriaTransfer.PenguinConditions.uuids` to filter penguins by uuids.
     * - Uses `PenguinCriteriaTransfer.SortTransfer.field` to set the `order by` field.
     * - Uses `PenguinCriteriaTransfer.SortTransfer.isAscending` to set ascending order otherwise will be used descending order.
     * - Uses `PenguinCriteriaTransfer.PaginationTransfer.{limit, offset}` to paginate result with limit and offset.
     * - Uses `PenguinCriteriaTransfer.PaginationTransfer.{page, maxPerPage}` to paginate result with page and maxPerPage.
     * - Executes `PenguinExpanderPluginInterface` before return the collection transfer.
     * - Returns `PenguinCollectionTransfer` filled with found penguins.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinCriteriaTransfer $penguinCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionTransfer
     */
    public function getPenguinCollection(PenguinCriteriaTransfer $penguinCriteriaTransfer): PenguinCollectionTransfer;

    /**
     * Specification:
     * - Stores collection of Penguins to the storage.
     * - Uses `PenguinValidatorInterface` to validate `PenguinTransfer` before save.
     * - Uses `PenguinValidatorRulePluginInterface` to validate `PenguinTransfer` before save.
     * - Executes pre-create `PenguinCreatePluginInterface` before create the `PenguinTransfer`.
     * - Executes post-create `PenguinCreatePluginInterface` after create the `PenguinTransfer`.
     * - Returns `PenguinCollectionResponseTransfer.PenguinTransfer[]` filled with created penguins.
     * - Returns `PenguinCollectionResponseTransfer.ErrorTransfer[]` filled with validation errors.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function createPenguinCollection(
        PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer,
    ): PenguinCollectionResponseTransfer;

    /**
     * Specification:
     * - Updates collection of Penguins in the storage.
     * - Uses `PenguinValidatorInterface` to validate `PenguinTransfer` before save.
     * - Uses `PenguinValidatorRulePluginInterface` to validate `PenguinTransfer` before save.
     * - Executes pre-update `PenguinUpdatePluginInterface` before update the `PenguinTransfer`.
     * - Executes post-update `PenguinUpdatePluginInterface` after update the `PenguinTransfer`.
     * - Returns `PenguinCollectionResponseTransfer.PenguinTransfer[]` filled with updated penguins.
     * - Returns `PenguinCollectionResponseTransfer.ErrorTransfer[]` filled with validation errors.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function updatePenguinCollection(PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer): PenguinCollectionResponseTransfer;

    /**
     * Specification:
     * - Deletes collection of Penguins from the storage by delete criteria.
     * - Uses `PenguinCollectionDeleteCriteriaTransfer.penguinIds` to filter penguins by penguinIds.
     * - Uses `PenguinCollectionDeleteCriteriaTransfer.uuids` to filter penguins by uuids.
     * - Uses `PenguinCollectionDeleteCriteriaTransfer.isTransactional` to make transactional delete.
     * - Returns `PenguinCollectionResponseTransfer.PenguinTransfer[]` filled with deleted penguins.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function deletePenguinCollection(
        PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer,
    ): PenguinCollectionResponseTransfer;
}
