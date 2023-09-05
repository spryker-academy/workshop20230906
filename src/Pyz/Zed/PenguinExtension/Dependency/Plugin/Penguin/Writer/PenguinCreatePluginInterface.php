<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer;

interface PenguinCreatePluginInterface
{
    /**
     * Specification:
     * - Executes plugin for `PenguinTransfer[]` before or after create them.
     * - Returns mapped `PenguinTransfer[]`.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinTransfer[] $penguinTransfers
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer[]
     */
    public function execute(array $penguinTransfers): array;
}
