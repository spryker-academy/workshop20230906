<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi;

use Pyz\Glue\PenguinsBackendApi\Processor\Creator\PenguinCreator;
use Pyz\Glue\PenguinsBackendApi\Processor\Deleter\PenguinDeleter;
use Pyz\Glue\PenguinsBackendApi\Processor\Mapper\PenguinMapper;
use Pyz\Glue\PenguinsBackendApi\Processor\Reader\PenguinReader;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder;
use Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\PenguinResponseBuilder;
use Pyz\Glue\PenguinsBackendApi\Processor\Updater\PenguinUpdater;
use Pyz\Zed\Penguin\Business\PenguinFacadeInterface;
use Spryker\Glue\Kernel\Backend\AbstractFactory;

/**
 * @method \Pyz\Glue\PenguinsBackendApi\PenguinsBackendApiConfig getConfig()
 */
class PenguinsBackendApiFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Glue\PenguinsBackendApi\Processor\Reader\PenguinReader
     */
    public function createPenguinReader(): PenguinReader
    {
        return new PenguinReader(
            $this->getPenguinFacade(),
            $this->createPenguinResponseBuilder(),
            $this->createErrorResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\PenguinsBackendApi\Processor\Creator\PenguinCreator
     */
    public function createPenguinCreator(): PenguinCreator
    {
        return new PenguinCreator(
            $this->getPenguinFacade(),
            $this->createPenguinMapper(),
            $this->createPenguinResponseBuilder(),
            $this->createErrorResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\PenguinsBackendApi\Processor\Updater\PenguinUpdater
     */
    public function createPenguinUpdater(): PenguinUpdater
    {
        return new PenguinUpdater(
            $this->getPenguinFacade(),
            $this->createPenguinMapper(),
            $this->createPenguinResponseBuilder(),
            $this->createErrorResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\PenguinsBackendApi\Processor\Deleter\PenguinDeleter
     */
    public function createPenguinDeleter(): PenguinDeleter
    {
        return new PenguinDeleter(
            $this->getPenguinFacade(),
            $this->createPenguinResponseBuilder(),
            $this->createErrorResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\PenguinResponseBuilder
     */
    public function createPenguinResponseBuilder(): PenguinResponseBuilder
    {
        return new PenguinResponseBuilder(
            $this->getConfig(),
            $this->createPenguinMapper(),
        );
    }

    /**
     * @return \Pyz\Glue\PenguinsBackendApi\Processor\ResponseBuilder\ErrorResponseBuilder
     */
    public function createErrorResponseBuilder(): ErrorResponseBuilder
    {
        return new ErrorResponseBuilder();
    }

    /**
     * @return \Pyz\Glue\PenguinsBackendApi\Processor\Mapper\PenguinMapper
     */
    public function createPenguinMapper(): PenguinMapper
    {
        return new PenguinMapper();
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\PenguinFacadeInterface
     */
    public function getPenguinFacade(): PenguinFacadeInterface
    {
        return $this->getProvidedDependency(PenguinsBackendApiDependencyProvider::FACADE_PENGUIN);
    }
}
