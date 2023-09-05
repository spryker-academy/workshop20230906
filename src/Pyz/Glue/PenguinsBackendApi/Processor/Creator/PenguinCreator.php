<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi\Processor\Creator;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;
use Generated\Shared\Transfer\PenguinTransfer;
use Pyz\Glue\PenguinsBackendApi\Processor\Mapper\PenguinMapper;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\PenguinResponseBuilder;
use Pyz\Zed\Penguin\Business\PenguinFacadeInterface;

class PenguinCreator
{
    /**
     * @var \Pyz\Zed\Penguin\Business\PenguinFacadeInterface
     */
    protected PenguinFacadeInterface $penguinFacade;

    /**
     * @var \Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\PenguinResponseBuilder
     */
    protected PenguinResponseBuilder $penguinResponseBuilder;

    /**
     * @var \Pyz\Glue\PenguinsBackendApi\Processor\Mapper\PenguinMapper
     */
    protected PenguinMapper $penguinMapper;

    /**
     * @var \Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder
     */
    protected ErrorResponseBuilder $errorResponseBuilder;

    /**
     * @param \Pyz\Zed\Penguin\Business\PenguinFacadeInterface $penguinFacade
     * @param \Pyz\Glue\PenguinsBackendApi\Processor\Mapper\PenguinMapper $penguinMapper
     * @param \Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\PenguinResponseBuilder $penguinResponseBuilder
     * @param \Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder $errorResponseBuilder
     */
    public function __construct(
        PenguinFacadeInterface $penguinFacade,
        PenguinMapper $penguinMapper,
        PenguinResponseBuilder $penguinResponseBuilder,
        ErrorResponseBuilder $errorResponseBuilder,
    ) {
        $this->penguinFacade = $penguinFacade;
        $this->penguinMapper = $penguinMapper;
        $this->penguinResponseBuilder = $penguinResponseBuilder;
        $this->errorResponseBuilder = $errorResponseBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function createPenguin(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\PenguinsBackendApiAttributesTransfer|null $penguinsBackendApiAttributesTransfer */
        $penguinsBackendApiAttributesTransfer = $glueRequestTransfer->getResourceOrFail()->getAttributes();

        if (!$penguinsBackendApiAttributesTransfer) {
            return $this->errorResponseBuilder->createWrongRequestBodyErrorResponse();
        }

        $penguinTransfer = $this->penguinMapper->mapPenguinsBackendApiAttributesTransferToPenguinTransfer(
            $penguinsBackendApiAttributesTransfer,
            new PenguinTransfer(),
        );

        $penguinCollectionRequestTransfer = $this->createPenguinCollectionRequestTransfer($penguinTransfer);
        $penguinCollectionResponseTransfer = $this->penguinFacade->createPenguinCollection($penguinCollectionRequestTransfer);

        $errorTransfers = $penguinCollectionResponseTransfer->getErrors();

        if ($errorTransfers->count()) {
            return $this->errorResponseBuilder
                ->createErrorResponse($errorTransfers);
        }

        return $this->penguinResponseBuilder->createPenguinResponse(
            $penguinCollectionResponseTransfer->getPenguins(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionRequestTransfer
     */
    protected function createPenguinCollectionRequestTransfer(
        PenguinTransfer $penguinTransfer,
    ): PenguinCollectionRequestTransfer {
        return (new PenguinCollectionRequestTransfer())
            ->addPenguin($penguinTransfer)
            ->setIsTransactional(true);
    }
}
