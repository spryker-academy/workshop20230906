<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Expander;

interface PenguinExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands `PenguinTransfer[]` after reading them.
     * - Returns expanded `PenguinTransfer[]`.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinTransfer[] $penguinTransfers
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer[]
     */
    public function expand(array $penguinTransfers): array;
}
