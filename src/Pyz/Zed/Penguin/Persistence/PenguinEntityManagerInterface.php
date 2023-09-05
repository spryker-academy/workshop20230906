<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Persistence;

use Generated\Shared\Transfer\PenguinTransfer;

interface PenguinEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function createPenguin(PenguinTransfer $penguinTransfer): PenguinTransfer;

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function updatePenguin(PenguinTransfer $penguinTransfer): PenguinTransfer;

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function deletePenguin(PenguinTransfer $penguinTransfer): PenguinTransfer;
}
