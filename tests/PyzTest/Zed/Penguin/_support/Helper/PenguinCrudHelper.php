<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Penguin\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\PenguinBuilder;
use Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;
use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;
use Generated\Shared\Transfer\PenguinCollectionTransfer;
use Generated\Shared\Transfer\PenguinConditionsTransfer;
use Generated\Shared\Transfer\PenguinCriteriaTransfer;
use Generated\Shared\Transfer\PenguinTransfer;
use Pyz\Zed\Penguin\Business\PenguinFacadeInterface;
use Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Expander\PenguinExpanderPluginInterface;
use Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinCreatePluginInterface;
use Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface;
use SprykerTest\Zed\Testify\Helper\Business\BusinessHelperTrait;

class PenguinCrudHelper extends Module
{
    use BusinessHelperTrait;

    /**
     * @var string
     */
    protected const UUID_ONE = 'ebad5042-0db1-498e-9981-42f45f98ad3d';

    /**
     * @var string
     */
    protected const UUID_TWO = 'b7b94e0f-ec4d-4341-9132-07342b45f659';

    /**
     * @return \Generated\Shared\Transfer\PenguinTransfer|null
     */
    public function havePenguinTransferWithUuidTwoPersisted(): ?PenguinTransfer
    {
        return $this->persistPenguin($this->havePenguinTransfer(['uuid' => static::UUID_TWO]));
    }

    /**
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function havePenguinTransferWithUuidTwo(): PenguinTransfer
    {
        return $this->havePenguinTransfer(['uuid' => static::UUID_ONE]);
    }

    /**
     * @return \Generated\Shared\Transfer\PenguinTransfer|null
     */
    public function havePenguinTransferWithUuidOnePersisted(): ?PenguinTransfer
    {
        return $this->persistPenguin($this->havePenguinTransfer(['uuid' => static::UUID_ONE]));
    }

    /**
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function havePenguinTransferWithUuidOne(): PenguinTransfer
    {
        return $this->havePenguinTransfer(['uuid' => static::UUID_ONE]);
    }

    /**
     * @param array<string, mixed> $seed
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer
     */
    public function havePenguinTransfer(array $seed = []): PenguinTransfer
    {
        $penguinBuilder = new PenguinBuilder($seed);

        return $penguinBuilder->build();
    }

    /**
     * @return \Generated\Shared\Transfer\PenguinCriteriaTransfer
     */
    public function havePenguinCriteriaTransferWithUuidOneCriteria(): PenguinCriteriaTransfer
    {
        $penguinCriteriaTransfer = new PenguinCriteriaTransfer();
        $penguinConditionsTransfer = new PenguinConditionsTransfer();
        $penguinConditionsTransfer->setUuids([static::UUID_ONE]);
        $penguinCriteriaTransfer->setPenguinConditions($penguinConditionsTransfer);

        return $penguinCriteriaTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer
     */
    public function havePenguinDeleteCriteriaTransferWithUuidOneCriteria(): PenguinCollectionDeleteCriteriaTransfer
    {
        $penguinCollectionDeleteCriteriaTransfer = new PenguinCollectionDeleteCriteriaTransfer();
        $penguinCollectionDeleteCriteriaTransfer->setUuids([static::UUID_ONE]);

        return $penguinCollectionDeleteCriteriaTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer
     */
    public function havePenguinDeleteCriteriaTransferWithUuidTwoCriteria(): PenguinCollectionDeleteCriteriaTransfer
    {
        $penguinCollectionDeleteCriteriaTransfer = new PenguinCollectionDeleteCriteriaTransfer();
        $penguinCollectionDeleteCriteriaTransfer->setUuids([static::UUID_TWO]);

        return $penguinCollectionDeleteCriteriaTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PenguinCriteriaTransfer
     */
    public function havePenguinCriteriaTransferWithUuidTwoCriteria(): PenguinCriteriaTransfer
    {
        $penguinCriteriaTransfer = new PenguinCriteriaTransfer();
        $penguinConditionsTransfer = new PenguinConditionsTransfer();
        $penguinConditionsTransfer->setUuids([static::UUID_TWO]);
        $penguinCriteriaTransfer->setPenguinConditions($penguinConditionsTransfer);

        return $penguinCriteriaTransfer;
    }

    /**
     * @param array<string, mixed> $seed
     *
     * @return \Generated\Shared\Transfer\AppTransfer|null
     */
    public function havePenguinTransferPersisted(array $seed = []): ?AppTransfer
    {
        return $this->persistPenguin($this->havePenguinTransfer($seed));
    }

    /**
     * @return void
     */
    public function havePenguinExpanderPluginSetUuidTwoEnabled(): void
    {
        $penguinExpanderPluginSetUuidTwo = new class (static::UUID_TWO) implements PenguinExpanderPluginInterface {
           /**
            * @var string
            */
            private $uuid;

           /**
            * @param string $uuid
            */
            public function __construct(string $uuid)
            {
                $this->uuid = $uuid;
            }

            /**
             * @param \Generated\Shared\Transfer\PenguinTransfer[] $penguinTransfers
             *
             * @return \Generated\Shared\Transfer\PenguinTransfer[]
             */
            public function expand(array $penguinTransfers): array
            {
                foreach ($penguinTransfers as $penguinTransfer) {
                    $penguinTransfer->setUuid($this->uuid);
                }

                return $penguinTransfers;
            }
        };

        $this->getBusinessHelper()->mockFactoryMethod('getPenguinExpanderPlugins', [$penguinExpanderPluginSetUuidTwo], 'Penguin');
    }

    /**
     * @return void
     */
    public function havePenguinPreCreatePluginSetUuidTwoEnabled(): void
    {
        $penguinPreCreatePlugin = $this->mockCreatePlugin();

        $this->getBusinessHelper()->mockFactoryMethod('getPenguinPreCreatePlugins', [$penguinPreCreatePlugin], 'Penguin');
    }

    /**
     * @return void
     */
    public function havePenguinPostCreatePluginSetUuidTwoEnabled(): void
    {
        $penguinPostCreatePlugin = $this->mockCreatePlugin();

        $this->getBusinessHelper()->mockFactoryMethod('getPenguinPostCreatePlugins', [$penguinPostCreatePlugin], 'Penguin');
    }

    /**
     * @return void
     */
    public function havePenguinPreUpdatePluginSetUuidTwoEnabled(): void
    {
        $penguinPreUpdatePlugin = $this->mockUpdatePlugin();

        $this->getBusinessHelper()->mockFactoryMethod('getPenguinPreUpdatePlugins', [$penguinPreUpdatePlugin], 'Penguin');
    }

    /**
     * @return void
     */
    public function havePenguinPostUpdatePluginSetUuidTwoEnabled(): void
    {
        $penguinPostUpdatePlugin = $this->mockUpdatePlugin();

        $this->getBusinessHelper()->mockFactoryMethod('getPenguinPostUpdatePlugins', [$penguinPostUpdatePlugin], 'Penguin');
    }

    /**
     * @return void
     */
    public function havePenguinAlwaysFailingCreateValidatorRuleEnabled(): void
    {
        $this->mockPenguinAlwaysFailingValidatorRule('getPenguinCreateValidatorRules');
    }

    /**
     * @return void
     */
    public function havePenguinAlwaysFailingUpdateValidatorRuleEnabled(): void
    {
        $this->mockPenguinAlwaysFailingValidatorRule('getPenguinUpdateValidatorRules');
    }

    /**
     * @return void
     */
    public function havePenguinAlwaysFailingCreateValidatorRulePluginEnabled(): void
    {
        $this->mockPenguinAlwaysFailingValidatorRule('getPenguinCreateValidatorRulePlugins');
    }

    /**
     * @return void
     */
    public function havePenguinAlwaysFailingUpdateValidatorRulePluginEnabled(): void
    {
        $this->mockPenguinAlwaysFailingValidatorRulePlugin('getPenguinUpdateValidatorRulePlugins');
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionTransfer $penguinCollectionTransfer
     *
     * @return void
     */
    public function assertPenguinCollectionIsEmpty(PenguinCollectionTransfer $penguinCollectionTransfer): void
    {
        $this->assertCount(0, $penguinCollectionTransfer->getPenguins(), sprintf('Expected to have an empty collection but found "%s" items', $penguinCollectionTransfer->getPenguins()->count()));
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     *
     * @return void
     */
    public function assertPenguinCollectionResponseIsEmpty(PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer): void
    {
        $this->assertCount(0, $penguinCollectionResponseTransfer->getPenguins(), sprintf('Expected to have an empty response collection but found "%s" items', $penguinCollectionResponseTransfer->getPenguins()->count()));
    }

   /**
    * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
    * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
    *
    * @return void
    */
    public function assertPenguinCollectionResponseContainsOneWithUuidOneTransferWithId(
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
        PenguinTransfer $penguinTransfer,
    ): void {
        $penguinCollectionTransfer = (new PenguinCollectionTransfer())->setPenguins($penguinCollectionResponseTransfer->getPenguins());

        $this->assertPenguinCollectionContainsTransferWithId($penguinCollectionTransfer, $penguinTransfer);
        $this->assertPenguinCollectionResponseContainsOneWithUuidOneTransfer($penguinCollectionResponseTransfer);
    }

   /**
    * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
    *
    * @return void
    */
    public function assertPenguinCollectionResponseContainsOneWithUuidOneTransfer(PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer): void
    {
        $this->assertCount(1, $penguinCollectionResponseTransfer->getPenguins());
        $this->assertEquals(static::UUID_ONE, $penguinCollectionResponseTransfer->getPenguins()[0]->getUuid());
    }

   /**
    * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
    * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
    *
    * @return void
    */
    public function assertPenguinCollectionResponseContainsOneWithUuidTwoTransferWithId(
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
        PenguinTransfer $penguinTransfer,
    ): void {
        $penguinCollectionTransfer = (new PenguinCollectionTransfer())->setPenguins($penguinCollectionResponseTransfer->getPenguins());

        $this->assertPenguinCollectionContainsTransferWithId($penguinCollectionTransfer, $penguinTransfer);
        $this->assertPenguinCollectionResponseContainsOneWithUuidTwoTransfer($penguinCollectionResponseTransfer);
    }

   /**
    * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
    *
    * @return void
    */
    public function assertPenguinCollectionResponseContainsOneWithUuidTwoTransfer(PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer): void
    {
        $this->assertCount(1, $penguinCollectionResponseTransfer->getPenguins());
        $this->assertEquals(static::UUID_TWO, $penguinCollectionResponseTransfer->getPenguins()[0]->getUuid());
    }

   /**
    * @param \Generated\Shared\Transfer\PenguinCollectionTransfer $penguinCollectionTransfer
    * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
    *
    * @return void
    */
    public function assertPenguinCollectionContainsTransferWithId(PenguinCollectionTransfer $penguinCollectionTransfer, PenguinTransfer $penguinTransfer): void
    {
        $transferFound = false;

        foreach ($penguinCollectionTransfer->getPenguins() as $penguinTransferFromCollection) {
            if ($penguinTransferFromCollection->getIdPenguin() === $penguinTransfer->getIdPenguin()) {
                $transferFound = true;
            }
        }

        $this->assertTrue($transferFound, sprintf('Expected to have a transfer in the collection but transfer by id "%s" was not found in the collection', $penguinTransfer->getIdPenguin()));
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer
     * @param string $message
     *
     * @return void
     */
    public function assertPenguinCollectionResponseContainsFailedValidationRuleError(
        PenguinCollectionResponseTransfer $penguinCollectionResponseTransfer,
        string $message = 'Validation failed',
    ): void {
        $errorFound = false;

        foreach ($penguinCollectionResponseTransfer->getErrors() as $errorTransfer) {
            if ($errorTransfer->getMessage() === $message) {
                $errorFound = true;
            }
        }

        $this->assertTrue($errorFound, sprintf('Expected to have a message "%s" in the error collection but was not found', $message));
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinTransfer|null
     */
    protected function persistPenguin(PenguinTransfer $penguinTransfer): ?PenguinTransfer
    {
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        $penguinCollectionResponseTransfer = $this->getFacade()->createPenguinCollection($penguinCollectionRequestTransfer);

        return $penguinCollectionResponseTransfer->getPenguins()->getIterator()->current();
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinCreatePluginInterface
     */
    protected function mockCreatePlugin(): PenguinCreatePluginInterface
    {
        return new class (static::UUID_TWO) implements \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinCreatePluginInterface {
            /**
             * @var string
             */
            private $uuid;

            /**
             * @param string $uuid
             */
            public function __construct(string $uuid)
            {
                $this->uuid = $uuid;
            }

            /**
             * @param \Generated\Shared\Transfer\PenguinTransfer[] $penguinTransfers
             *
             * @return \Generated\Shared\Transfer\PenguinTransfer[]
             */
            public function execute(array $penguinTransfers): array
            {
                foreach ($penguinTransfers as $penguinTransfer) {
                    $penguinTransfer->setUuid($this->uuid);
                }

                return $penguinTransfers;
            }
        };
    }

    /**
     * @return \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface
     */
    protected function mockUpdatePlugin(): PenguinUpdatePluginInterface
    {
        return new class (static::UUID_TWO) implements \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Writer\PenguinUpdatePluginInterface {
           /**
            * @var string
            */
            private $uuid;

           /**
            * @param string $uuid
            */
            public function __construct(string $uuid)
            {
                $this->uuid = $uuid;
            }

           /**
            * @param \Generated\Shared\Transfer\PenguinTransfer[] $penguinTransfers
            *
            * @return \Generated\Shared\Transfer\PenguinTransfer[]
            */
            public function execute(array $penguinTransfers): array
            {
                foreach ($penguinTransfers as $penguinTransfer) {
                    $penguinTransfer->setUuid($this->uuid);
                }

                return $penguinTransfers;
            }
        };
    }

    /**
     * @param string $factoryMethod
     *
     * @return void
     */
    protected function mockPenguinAlwaysFailingValidatorRule(string $factoryMethod): void
    {
        $penguinValidatorRule = new class implements \Pyz\Zed\Penguin\Business\Penguin\Validator\Rules\PenguinValidatorRuleInterface {
            /**
             * @param \Generated\Shared\Transfer\PenguinTransfer $penguinTransfer
             *
             * @return array<string>
             */
            public function validate(PenguinTransfer $penguinTransfer): array
            {
                return ['Validation failed'];
            }
        };

        $this->getBusinessHelper()->mockFactoryMethod($factoryMethod, [$penguinValidatorRule], 'Penguin');
    }

    /**
     * @param string $factoryMethod
     *
     * @return void
     */
    protected function mockPenguinAlwaysFailingValidatorRulePlugin(string $factoryMethod): void
    {
        $penguinValidatorRulePlugin = new class implements \Pyz\Zed\PenguinExtension\Dependency\Plugin\Penguin\Validator\PenguinValidatorRulePluginInterface {
            /**
             * @param \Generated\Shared\Transfer\PenguinTransfer|array $penguinTransfer
             *
             * @return array<string>
             */
            public function validate(PenguinTransfer $penguinTransfer): array
            {
                return ['Validation failed'];
            }
        };

        $this->getBusinessHelper()->mockFactoryMethod($factoryMethod, [$penguinValidatorRulePlugin], 'Penguin');
    }

    /**
     * @return \Pyz\Zed\Penguin\Business\PenguinFacadeInterface
     */
    protected function getFacade(): PenguinFacadeInterface
    {
        /** @var \Pyz\Zed\Penguin\Business\PenguinFacadeInterface */
        return $this->getBusinessHelper()->getFacade('Penguin');
    }
}
