<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business;

use Pyz\Zed\Penguin\Business\Penguin\Deleter\PenguinDeleter;
use Pyz\Zed\Penguin\Business\Penguin\Deleter\PenguinDeleterInterface;
use Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder\PenguinIdentifierBuilder;
use Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder\PenguinIdentifierBuilderInterface;
use Pyz\Zed\Penguin\Business\Penguin\Reader\PenguinReader;
use Pyz\Zed\Penguin\Business\Penguin\Reader\PenguinReaderInterface;
use Pyz\Zed\Penguin\Business\Penguin\Validator\PenguinValidator;
use Pyz\Zed\Penguin\Business\Penguin\Validator\PenguinValidatorInterface;
use Pyz\Zed\Penguin\Business\Penguin\Writer\PenguinCreator;
use Pyz\Zed\Penguin\Business\Penguin\Writer\PenguinCreatorInterface;
use Pyz\Zed\Penguin\Business\Penguin\Writer\PenguinUpdater;
use Pyz\Zed\Penguin\Business\Penguin\Writer\PenguinUpdaterInterface;
use Pyz\Zed\Penguin\PenguinDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\Penguin\PenguinConfig getConfig()
 * @method \Pyz\Zed\Penguin\Persistence\PenguinEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface getRepository()
 */
class PenguinBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\Penguin\Business\Penguin\Deleter\PenguinDeleterInterface
     */
    public function createPenguinDeleter(): PenguinDeleterInterface
    {
        return new PenguinDeleter($this->getEntityManager(), $this->getRepository());
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\Penguin\Writer\PenguinCreatorInterface
     */
    public function createPenguinCreator(): PenguinCreatorInterface
    {
        return new PenguinCreator($this->getEntityManager(), $this->createPenguinCreateValidator(), $this->createPenguinIdentifierBuilder(), $this->getPenguinPreCreatePlugins(), $this->getPenguinPostCreatePlugins());
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\Penguin\Reader\PenguinReaderInterface
     */
    public function createPenguinReader(): PenguinReaderInterface
    {
        return new PenguinReader($this->getRepository(), $this->getPenguinExpanderPlugins());
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\Penguin\Writer\PenguinUpdaterInterface
     */
    public function createPenguinUpdater(): PenguinUpdaterInterface
    {
        return new PenguinUpdater($this->getEntityManager(), $this->createPenguinUpdateValidator(), $this->createPenguinIdentifierBuilder(), $this->getPenguinPreUpdatePlugins(), $this->getPenguinPostUpdatePlugins());
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\Penguin\IdentifierBuilder\PenguinIdentifierBuilderInterface
     */
    public function createPenguinIdentifierBuilder(): PenguinIdentifierBuilderInterface
    {
        return new PenguinIdentifierBuilder();
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\Penguin\Validator\PenguinValidatorInterface
     */
    public function createPenguinCreateValidator(): PenguinValidatorInterface
    {
        return new PenguinValidator($this->getPenguinCreateValidatorRules(), $this->getPenguinCreateValidatorRulePlugins(), $this->createPenguinIdentifierBuilder());
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\Penguin\Validator\Rules\PenguinValidatorRuleInterface[]
     */
    public function getPenguinCreateValidatorRules(): array
    {
        return [];
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\Penguin\Validator\PenguinValidatorInterface
     */
    public function createPenguinUpdateValidator(): PenguinValidatorInterface
    {
        return new PenguinValidator($this->getPenguinUpdateValidatorRules(), $this->getPenguinUpdateValidatorRulePlugins(), $this->createPenguinIdentifierBuilder());
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\Penguin\Validator\Rules\PenguinValidatorRuleInterface[]
     */
    public function getPenguinUpdateValidatorRules(): array
    {
        return [];
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Expander\PenguinExpanderPluginInterface[]
     */
    public function getPenguinExpanderPlugins(): array
    {
        return $this->getProvidedDependency(PenguinDependencyProvider::PLUGINS_PENGUIN_EXPANDER);
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinCreatePluginInterface[]
     */
    public function getPenguinPreCreatePlugins(): array
    {
        return $this->getProvidedDependency(PenguinDependencyProvider::PLUGINS_PENGUIN_PRE_CREATE);
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinCreatePluginInterface[]
     */
    public function getPenguinPostCreatePlugins(): array
    {
        return $this->getProvidedDependency(PenguinDependencyProvider::PLUGINS_PENGUIN_POST_CREATE);
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface[]
     */
    public function getPenguinPreUpdatePlugins(): array
    {
        return $this->getProvidedDependency(PenguinDependencyProvider::PLUGINS_PENGUIN_PRE_UPDATE);
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface[]
     */
    public function getPenguinPostUpdatePlugins(): array
    {
        return $this->getProvidedDependency(PenguinDependencyProvider::PLUGINS_PENGUIN_POST_UPDATE);
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Validator\PenguinValidatorRulePluginInterface[]
     */
    public function getPenguinCreateValidatorRulePlugins(): array
    {
        return $this->getProvidedDependency(PenguinDependencyProvider::PLUGINS_PENGUIN_CREATE_VALIDATOR_RULE);
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Validator\PenguinValidatorRulePluginInterface[]
     */
    public function getPenguinUpdateValidatorRulePlugins(): array
    {
        return $this->getProvidedDependency(PenguinDependencyProvider::PLUGINS_PENGUIN_UPDATE_VALIDATOR_RULE);
    }
}
