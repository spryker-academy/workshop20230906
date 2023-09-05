<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi\Processor\Reader;

use ArrayObject;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\PenguinConditionsTransfer;
use Generated\Shared\Transfer\PenguinCriteriaTransfer;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\PenguinResponseBuilder;
use Pyz\Zed\Penguin\Business\PenguinFacadeInterface;

class PenguinReader
{
    protected PenguinFacadeInterface $penguinFacade;

    protected PenguinResponseBuilder $penguinResponseBuilder;

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
    public function getPenguinCollection(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $penguinCriteriaTransfer = (new PenguinCriteriaTransfer())
            ->setPagination($glueRequestTransfer->getPagination())
            ->setSortCollection($glueRequestTransfer->getSortings());

        $penguinTransfers = $this->penguinFacade
            ->getPenguinCollection($penguinCriteriaTransfer)
            ->getPenguins();

        return $this->penguinResponseBuilder->createPenguinResponse($penguinTransfers);
    }

    /**
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function getPenguin(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $penguinConditionsTransfer = (new PenguinConditionsTransfer())
            ->addUuid($glueRequestTransfer->getResourceOrFail()->getIdOrFail());

        $penguinCriteriaTransfer = (new PenguinCriteriaTransfer())
            ->setPenguinConditions($penguinConditionsTransfer);

        $penguinTransfers = $this->penguinFacade
            ->getPenguinCollection($penguinCriteriaTransfer)
            ->getPenguins();

        if ($penguinTransfers->count() === 1) {
            return $this->penguinResponseBuilder->createPenguinResponse(
                new ArrayObject([$penguinTransfers->getIterator()->current()]),
            );
        }

        return $this->errorResponseBuilder->createPenguinNotFoundErrorResponse();
    }
}
