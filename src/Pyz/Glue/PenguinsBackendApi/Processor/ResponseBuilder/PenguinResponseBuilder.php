<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder;

use ArrayObject;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\PenguinsBackendApiAttributesTransfer;
use Generated\Shared\Transfer\PenguinTransfer;
use Pyz\Glue\PenguinsBackendApi\PenguinsBackendApiConfig;
use Pyz\Glue\PenguinsBackendApi\Processor\Mapper\PenguinMapper;
use Symfony\Component\HttpFoundation\Response;

class PenguinResponseBuilder
{
    /**
     * @var \Pyz\Glue\PenguinsBackendApi\PenguinsBackendApiConfig
     */
    protected PenguinsBackendApiConfig $penguinsBackendApiConfig;

    /**
     * @var \Pyz\Glue\PenguinsBackendApi\Processor\Mapper\PenguinMapper
     */
    protected PenguinMapper $penguinMapper;

    /**
     * @param \Pyz\Glue\PenguinsBackendApi\PenguinsBackendApiConfig $penguinsBackendApiConfig
     * @param \Pyz\Glue\PenguinsBackendApi\Processor\Mapper\PenguinMapper $penguinMapper
     */
    public function __construct(
        PenguinsBackendApiConfig $penguinsBackendApiConfig,
        PenguinMapper $penguinMapper,
    ) {
        $this->penguinsBackendApiConfig = $penguinsBackendApiConfig;
        $this->penguinMapper = $penguinMapper;
    }

    /**
     * @param \ArrayObject<array-key, \Generated\Shared\Transfer\PenguinTransfer> $penguinTransfers
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function createPenguinResponse(
        ArrayObject $penguinTransfers,
    ): GlueResponseTransfer {
        $glueResponseTransfer = new GlueResponseTransfer();

        foreach ($penguinTransfers as $penguinTransfer) {
            $glueResponseTransfer->addResource(
                $this->createPenguinResourceTransfer($penguinTransfer),
            );
        }

        return $glueResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function createNoContentResponse(): GlueResponseTransfer
    {
        return (new GlueResponseTransfer())->setHttpStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResourceTransfer
     */
    protected function createPenguinResourceTransfer(
        PenguinTransfer $penguinTransfer,
    ): GlueResourceTransfer {
        $penguinsBackendApiAttributesTransfer = $this->penguinMapper
            ->mapPenguinTransferToPenguinsBackendApiAttributesTransfer(
                $penguinTransfer,
                new PenguinsBackendApiAttributesTransfer(),
            );

        return (new GlueResourceTransfer())
            ->setId($penguinTransfer->getUuidOrFail())
            ->setType(PenguinsBackendApiConfig::RESOURCE_PENGUINS)
            ->setAttributes($penguinsBackendApiAttributesTransfer);
    }
}
