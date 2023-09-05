<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business\Penguin\Validator;

use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;
use Generated\Shared\Transfer\PenguinTransfer;

interface PenguinValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function validateCollection(
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
    ): PenguinCollectionResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function validate(
        PenguinTransfer $penguinTransfer,
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
    ): PenguinCollectionResponseTransfer;
}
