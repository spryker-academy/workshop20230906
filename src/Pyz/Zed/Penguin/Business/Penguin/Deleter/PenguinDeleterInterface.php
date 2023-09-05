<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business\Penguin\Deleter;

use Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;

interface PenguinDeleterInterface
{
    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function deletePenguinCollection(
        PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer,
    ): PenguinCollectionResponseTransfer;
}
