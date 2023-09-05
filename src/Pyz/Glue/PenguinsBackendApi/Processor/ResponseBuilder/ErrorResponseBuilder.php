<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder;

use ArrayObject;
use Generated\Shared\Transfer\ErrorTransfer;
use Generated\Shared\Transfer\GlueErrorTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Pyz\Glue\PenguinsBackendApi\PenguinsBackendApiConfig;
use Symfony\Component\HttpFoundation\Response;

class ErrorResponseBuilder
{
    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\ErrorTransfer> $errorTransfers
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function createErrorResponse(ArrayObject $errorTransfers): GlueResponseTransfer
    {
        $glueResponseTransfer = new GlueResponseTransfer();

        foreach ($errorTransfers as $errorTransfer) {
            $glueErrorTransfer = $this->createGenericGlueErrorTransfer(
                $errorTransfer,
            );

            $glueResponseTransfer->addError($glueErrorTransfer);
        }

        return $this->setGlueResponseHttpStatus($glueResponseTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function createPenguinNotFoundErrorResponse(): GlueResponseTransfer
    {
        $glueResponseTransfer = (new GlueResponseTransfer())
            ->addError($this->createPenguinNotFoundError());

        return $this->setGlueResponseHttpStatus($glueResponseTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function createWrongRequestBodyErrorResponse(): GlueResponseTransfer
    {
        $glueResponseTransfer = (new GlueResponseTransfer())
            ->addError($this->createWrongRequestBodyError());

        return $this->setGlueResponseHttpStatus($glueResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErrorTransfer $errorTransfer
     *
     * @return \Generated\Shared\Transfer\GlueErrorTransfer
     */
    protected function createGenericGlueErrorTransfer(ErrorTransfer $errorTransfer): GlueErrorTransfer
    {
        return (new GlueErrorTransfer())
            ->setCode(PenguinsBackendApiConfig::RESPONSE_CODE_BAD_REQUEST)
            ->setMessage($errorTransfer->getMessageOrFail())
            ->setStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return \Generated\Shared\Transfer\GlueErrorTransfer
     */
    protected function createPenguinNotFoundError(): GlueErrorTransfer
    {
        return (new GlueErrorTransfer())
            ->setCode(PenguinsBackendApiConfig::RESPONSE_CODE_PENGUIN_NOT_FOUND)
            ->setMessage(PenguinsBackendApiConfig::RESPONSE_DETAIL_PENGUIN_NOT_FOUND)
            ->setStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @return \Generated\Shared\Transfer\GlueErrorTransfer
     */
    protected function createWrongRequestBodyError(): GlueErrorTransfer
    {
        return (new GlueErrorTransfer())
            ->setCode(PenguinsBackendApiConfig::RESPONSE_CODE_WRONG_REQUEST_BODY)
            ->setMessage(PenguinsBackendApiConfig::RESPONSE_DETAIL_PENGUIN_NOT_FOUND)
            ->setStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param \Generated\Shared\Transfer\GlueResponseTransfer $glueResponseTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    protected function setGlueResponseHttpStatus(GlueResponseTransfer $glueResponseTransfer): GlueResponseTransfer
    {
        $glueErrorTransfers = $glueResponseTransfer->getErrors();

        if ($glueErrorTransfers->count() !== 1) {
            return $glueResponseTransfer->setHttpStatus(
                Response::HTTP_MULTI_STATUS,
            );
        }

        $glueErrorTransfer = $glueErrorTransfers->getIterator()->current();

        return $glueResponseTransfer->setHttpStatus(
            $glueErrorTransfer->getStatus(),
        );
    }
}
