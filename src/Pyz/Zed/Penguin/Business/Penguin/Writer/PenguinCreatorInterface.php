<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business\Penguin\Writer;

use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;
use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;

interface PenguinCreatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function createPenguinCollection(
        PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer,
    ): PenguinCollectionResponseTransfer;
}
