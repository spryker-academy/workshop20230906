<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Persistence;

use Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\PenguinCollectionTransfer;
use Generated\Shared\Transfer\PenguinCriteriaTransfer;

interface PenguinRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\PenguinCriteriaTransfer $penguinCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionTransfer
     */
    public function getPenguinCollection(PenguinCriteriaTransfer $penguinCriteriaTransfer): PenguinCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionTransfer
     */
    public function getPenguinDeleteCollection(
        PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer,
    ): PenguinCollectionTransfer;
}
