<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi\Processor\Deleter;


use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;
use Generated\Shared\Transfer\PenguinConditionsTransfer;
use Generated\Shared\Transfer\PenguinCriteriaTransfer;
use Generated\Shared\Transfer\PenguinTransfer;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\PenguinResponseBuilder;
use Pyz\Zed\Penguin\Business\PenguinFacadeInterface;

class PenguinDeleter
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
     * @var \Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder
     */
    protected ErrorResponseBuilder $errorResponseBuilder;

    /**
     * @param \Pyz\Zed\Penguin\Business\PenguinFacadeInterface $penguinFacade
     * @param \Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\PenguinResponseBuilder $penguinResponseBuilder
     * @param \Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder $errorResponseBuilder
     */
    public function __construct(
        PenguinFacadeInterface $penguinFacade,
        PenguinResponseBuilder $penguinResponseBuilder,
        ErrorResponseBuilder $errorResponseBuilder,
    ) {
        $this->penguinFacade = $penguinFacade;
        $this->penguinResponseBuilder = $penguinResponseBuilder;
        $this->errorResponseBuilder = $errorResponseBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function deletePenguin(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $glueResourceTransfer = $glueRequestTransfer->getResourceOrFail();

        $penguinTransfer = $this->findPenguin($glueResourceTransfer->getIdOrFail());

        if (!$penguinTransfer) {
            return $this->errorResponseBuilder->createPenguinNotFoundErrorResponse();
        }

        $penguinCollectionDeleteCriteriaTransfer = $this->createPenguinCollectionDeleteCriteriaTransfer(
            $glueRequestTransfer,
        );
        $penguinCollectionResponseTransfer = $this->penguinFacade->deletePenguinCollection(
            $penguinCollectionDeleteCriteriaTransfer,
        );

        if ($penguinCollectionResponseTransfer->getErrors()->count() !== 0) {
            return $this->errorResponseBuilder->createErrorResponse(
                $penguinCollectionResponseTransfer->getErrors(),
            );
        }

        return $this->penguinResponseBuilder->createNoContentResponse();
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

    /**
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer
     */
    protected function createPenguinCollectionDeleteCriteriaTransfer(
        GlueRequestTransfer $glueRequestTransfer
    ): PenguinCollectionDeleteCriteriaTransfer {
        return (new PenguinCollectionDeleteCriteriaTransfer())->addUuid(
            $glueRequestTransfer->getResourceOrFail()->getIdOrFail(),
        );
    }
}
