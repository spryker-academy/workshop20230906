<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi\Processor\Updater;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;
use Generated\Shared\Transfer\PenguinConditionsTransfer;
use Generated\Shared\Transfer\PenguinCriteriaTransfer;
use Generated\Shared\Transfer\PenguinTransfer;
use Pyz\Glue\PenguinsBackendApi\Processor\Mapper\PenguinMapper;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\PenguinResponseBuilder;
use Pyz\Zed\Penguin\Business\PenguinFacadeInterface;

class PenguinUpdater
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
    public function updatePenguin(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        if (!$this->isRequestedEntityValid($glueRequestTransfer)) {
            return $this->errorResponseBuilder->createWrongRequestBodyErrorResponse();
        }

        $glueResourceTransfer = $glueRequestTransfer->getResourceOrFail();

        /**
         * @var \Generated\Shared\Transfer\PenguinsBackendApiAttributesTransfer $penguinsBackendApiAttributesTransfer
         */
        $penguinsBackendApiAttributesTransfer = $glueResourceTransfer->getAttributesOrFail();

        $penguinTransfer = $this->findPenguin($glueResourceTransfer->getIdOrFail());

        if (!$penguinTransfer) {
            return $this->errorResponseBuilder->createPenguinNotFoundErrorResponse();
        }

        $penguinTransfer = $this->penguinMapper->mapPenguinsBackendApiAttributesTransferToPenguinTransfer(
            $penguinsBackendApiAttributesTransfer,
            $penguinTransfer,
        );

        $penguinCollectionRequestTransfer = $this->createPenguinCollectionRequestTransfer($penguinTransfer);
        $penguinCollectionResponseTransfer = $this->penguinFacade->updatePenguinCollection($penguinCollectionRequestTransfer);

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
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return bool
     */
    protected function isRequestedEntityValid(GlueRequestTransfer $glueRequestTransfer): bool
    {
        $glueResourceTransfer = $glueRequestTransfer->getResourceOrFail();

        return $glueResourceTransfer->getId()
            && $glueResourceTransfer->getAttributes()
            && array_filter($glueResourceTransfer->getAttributesOrFail()->modifiedToArray(), function ($value) {
                return $value !== null;
            });
    }

    /**
     * @param string $uuid
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer|null
     */
    protected function findPenguin(string $uuid): ?PenguinTransfer
    {
        $penguinConditionsTransfer = (new PenguinConditionsTransfer())
            ->addUuid($uuid);
        $penguinCriteriaTransfer = (new PenguinCriteriaTransfer())
            ->setPenguinConditions($penguinConditionsTransfer);

        $penguinTransfers = $this->penguinFacade
            ->getPenguinCollection($penguinCriteriaTransfer)
            ->getPenguins();

        return $penguinTransfers->getIterator()->current();
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
