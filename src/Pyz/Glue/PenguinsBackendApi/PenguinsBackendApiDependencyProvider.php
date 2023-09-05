<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi;

use Pyz\Zed\Penguin\Business\PenguinFacadeInterface;
use Spryker\Glue\Kernel\Backend\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Backend\Container;

class PenguinsBackendApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PENGUIN = 'FACADE_PENGUIN';

    /**
     * @param \Spryker\Glue\Kernel\Backend\Container $container
     *
     * @return \Spryker\Glue\Kernel\Backend\Container
     */
    public function provideBackendDependencies(Container $container): Container
    {
        $container = parent::provideBackendDependencies($container);

        $container = $this->addPenguinFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Backend\Container $container
     *
     * @return \Spryker\Glue\Kernel\Backend\Container
     */
    protected function addPenguinFacade(Container $container): Container
    {
        $container[static::FACADE_PENGUIN] = function (Container $container): PenguinFacadeInterface {
            return $container->getLocator()->penguin()->facade();
        };

        return $container;
    }
}
