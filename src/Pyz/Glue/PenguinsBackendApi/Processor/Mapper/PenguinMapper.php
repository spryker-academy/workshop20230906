<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi\Processor\Mapper;

use Generated\Shared\Transfer\PenguinsBackendApiAttributesTransfer;
use Generated\Shared\Transfer\PenguinTransfer;

class PenguinMapper
{
    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinsBackendApiAttributesTransfer
     */
    public function mapPenguinTransferToPenguinsBackendApiAttributesTransfer(
        PenguinTransfer $penguinTransfer,
    ): PenguinsBackendApiAttributesTransfer {
        return (new PenguinsBackendApiAttributesTransfer())->fromArray($penguinTransfer->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinsBackendApiAttributesTransfer $penguinsBackendApiAttributesTransfer
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function mapPenguinsBackendApiAttributesTransferToPenguinTransfer(
        PenguinsBackendApiAttributesTransfer $penguinsBackendApiAttributesTransfer,
        PenguinTransfer $penguinTransfer,
    ): PenguinTransfer {
        $penguinsBackendApiAttributesData = array_filter(
            $penguinsBackendApiAttributesTransfer->modifiedToArray(),
            function ($value) {
                return $value !== null;
            },
        );

        $penguinTransfer->fromArray($penguinsBackendApiAttributesData, true);

        return $penguinTransfer;
    }
}
