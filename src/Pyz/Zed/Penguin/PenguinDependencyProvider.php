<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Pyz\Zed\Penguin\PenguinConfig getConfig()
 */
class PenguinDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGINS_PENGUIN_PRE_CREATE = 'PLUGINS_PENGUIN_PRE_CREATE';

    /**
     * @var string
     */
    public const PLUGINS_PENGUIN_POST_CREATE = 'PLUGINS_PENGUIN_POST_CREATE';

    /**
     * @var string
     */
    public const PLUGINS_PENGUIN_PRE_UPDATE = 'PLUGINS_PENGUIN_PRE_UPDATE';

    /**
     * @var string
     */
    public const PLUGINS_PENGUIN_POST_UPDATE = 'PLUGINS_PENGUIN_POST_UPDATE';

    /**
     * @var string
     */
    public const PLUGINS_PENGUIN_EXPANDER = 'PLUGINS_PENGUIN_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_PENGUIN_CREATE_VALIDATOR_RULE = 'PLUGINS_PENGUIN_CREATE_VALIDATOR_RULE';

    /**
     * @var string
     */
    public const PLUGINS_PENGUIN_UPDATE_VALIDATOR_RULE = 'PLUGINS_PENGUIN_UPDATE_VALIDATOR_RULE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addPenguinPreCreatePlugins($container);
        $container = $this->addPenguinPostCreatePlugins($container);
        $container = $this->addPenguinPreUpdatePlugins($container);
        $container = $this->addPenguinPostUpdatePlugins($container);
        $container = $this->addPenguinExpanderPlugins($container);
        $container = $this->addPenguinCreateValidatorRulePlugins($container);
        $container = $this->addPenguinUpdateValidatorRulePlugins($container);

        return $container;
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinCreatePluginInterface[]
     */
    protected function getPenguinPreCreatePlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPenguinPreCreatePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PENGUIN_PRE_CREATE, function (Container $container) {
            return $this->getPenguinPreCreatePlugins();
        });

        return $container;
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinCreatePluginInterface[]
     */
    protected function getPenguinPostCreatePlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPenguinPostCreatePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PENGUIN_POST_CREATE, function (Container $container) {
            return $this->getPenguinPostCreatePlugins();
        });

        return $container;
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface[]
     */
    protected function getPenguinPreUpdatePlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPenguinPreUpdatePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PENGUIN_PRE_UPDATE, function (Container $container) {
            return $this->getPenguinPreUpdatePlugins();
        });

        return $container;
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface[]
     */
    protected function getPenguinPostUpdatePlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPenguinPostUpdatePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PENGUIN_POST_UPDATE, function (Container $container) {
            return $this->getPenguinPostUpdatePlugins();
        });

        return $container;
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Expander\PenguinExpanderPluginInterface[]
     */
    protected function getPenguinExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPenguinExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PENGUIN_EXPANDER, function (Container $container) {
            return $this->getPenguinExpanderPlugins();
        });

        return $container;
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Validator\PenguinValidatorRulePluginInterface[]
     */
    protected function getPenguinCreateValidatorRulePlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPenguinCreateValidatorRulePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PENGUIN_CREATE_VALIDATOR_RULE, function (Container $container) {
            return $this->getPenguinCreateValidatorRulePlugins();
        });

        return $container;
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Validator\PenguinValidatorRulePluginInterface[]
     */
    protected function getPenguinUpdateValidatorRulePlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPenguinUpdateValidatorRulePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PENGUIN_UPDATE_VALIDATOR_RULE, function (Container $container) {
            return $this->getPenguinUpdateValidatorRulePlugins();
        });

        return $container;
    }
}
