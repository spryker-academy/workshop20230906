<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Validator;

use Generated\Shared\Transfer\PenguinTransfer;

interface PenguinValidatorRulePluginInterface
{
    /**
     * Specification:
     * - Validates the `PenguinTransfer`.
     * - Returns an array with errors for the `PenguinTransfer`.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return string[]
     */
    public function validate(PenguinTransfer $penguinTransfer): array;
}
