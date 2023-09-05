<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business\Penguin\Validator\Rules;

use Generated\Shared\Transfer\PenguinTransfer;

interface PenguinValidatorRuleInterface
{
    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return string[]
     */
    public function validate(PenguinTransfer $penguinTransfer): array;
}
