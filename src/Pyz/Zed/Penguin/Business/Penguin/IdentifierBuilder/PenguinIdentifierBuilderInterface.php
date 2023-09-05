<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder;

use Generated\Shared\Transfer\PenguinTransfer;

interface PenguinIdentifierBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return string
     */
    public function buildIdentifier(PenguinTransfer $penguinTransfer): string;
}
