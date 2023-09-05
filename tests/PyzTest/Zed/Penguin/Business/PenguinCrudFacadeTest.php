<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Penguin\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Penguin
 * @group Business
 * @group Facade
 * @group PenguinCrudFacadeTest
 * Add your own group annotations below this line
 */
class PenguinCrudFacadeTest extends Unit
{
    /**
     * @var \PyzTest\Zed\Penguin\PenguinBusinessTester
     */
    protected $tester;

    /**
     * Test ensures to always get a Collection back even if no entity was found.
     *
     * @return void
     */
    public function testGetPenguinReturnsEmptyCollectionWhenNoEntityMatchedByCriteria(): void
    {
        // Arrange
        $this->tester->havePenguinTransferWithUuidTwoPersisted();
        $penguinCriteriaTransfer = $this->tester->havePenguinCriteriaTransferWithUuidOneCriteria();

        // Act
        $penguinCollectionTransfer = $this->tester->getFacade()->getPenguinCollection($penguinCriteriaTransfer);

        // Assert
        $this->tester->assertPenguinCollectionIsEmpty($penguinCollectionTransfer);
    }

    /**
     * Test ensures to get a Collection with entities back when criteria was matching.
     *
     * @return void
     */
    public function testGetPenguinReturnsCollectionWithOnePenguinEntityWhenCriteriaMatched(): void
    {
        // Arrange
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOnePersisted();
        $penguinCriteriaTransfer = $this->tester->havePenguinCriteriaTransferWithUuidOneCriteria();

        // Act
        $penguinCollectionTransfer = $this->tester->getFacade()->getPenguinCollection($penguinCriteriaTransfer);

        // Assert
        $this->tester->assertPenguinCollectionContainsTransferWithId($penguinCollectionTransfer, $penguinTransfer);
    }

    /**
     * Test ensures that expanders are applied to found entities.
     *
     * @return void
     */
    public function testGetPenguinCollectionReturnsCollectionWithOneExpandedPenguinEntity(): void
    {
        // Arrange
        $this->tester->havePenguinExpanderPluginSetUuidTwoEnabled();
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOnePersisted();

        $penguinCriteriaTransfer = $this->tester->havePenguinCriteriaTransferWithUuidOneCriteria();

        // Act
        $penguinCollectionTransfer = $this->tester->getFacade()->getPenguinCollection($penguinCriteriaTransfer);

        // Assert
        $this->tester->assertPenguinCollectionContainsTransferWithId($penguinCollectionTransfer, $penguinTransfer);
    }

    /**
     * @return void
     */
    public function testCreatePenguinCollectionReturnsCollectionWithOnePenguinEntityWhenEntityWasSaved(): void
    {
        // Arrange
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOne();
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->createPenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertpenguinCollectionResponseContainsOneWithUuidOneTransfer($penguinCollectionResponseTransfer);
    }

    /**
     * Tests that pre-create plugins are applied to entities.
     *
     * @return void
     */
    public function testCreatePenguinCollectionAppliesPreCreatePlugins(): void
    {
        // Arrange
        $this->tester->havePenguinPreCreatePluginSetUuidTwoEnabled();
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOne();
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->createPenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertpenguinCollectionResponseContainsOneWithUuidTwoTransfer($penguinCollectionResponseTransfer, $penguinTransfer);
    }

    /**
     * Tests that post-create plugins are applied to entities.
     *
     * @return void
     */
    public function testCreatePenguinCollectionAppliesPostCreatePlugins(): void
    {
        // Arrange
        $this->tester->havePenguinPostCreatePluginSetUuidTwoEnabled();
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOne();
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->createPenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertpenguinCollectionResponseContainsOneWithUuidTwoTransfer($penguinCollectionResponseTransfer, $penguinTransfer);
    }

    /**
     * Tests that entities are validated with internal ValidatorRuleInterface.
     *
     * @return void
     */
    public function testCreatePenguinCollectionReturnsErroredCollectionResponseWhenValidationRuleFailed(): void
    {
        // Arrange
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOnePersisted();

        $this->tester->havePenguinAlwaysFailingCreateValidatorRuleEnabled(); // This will always return a validation error
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->createPenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertPenguinCollectionResponseContainsFailedValidationRuleError($penguinCollectionResponseTransfer);
    }

    /**
     * Tests that entities are validated with external ValidatorRulePluginInterface.
     *
     * @return void
     */
    public function testCreatePenguinCollectionReturnsErroredCollectionResponseWhenValidationRulePluginFailed(): void
    {
        // Arrange
        $this->tester->havePenguinAlwaysFailingCreateValidatorRulePluginEnabled(); // This will always return a validation error
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOne();
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->createPenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertPenguinCollectionResponseContainsFailedValidationRuleError($penguinCollectionResponseTransfer);
    }

    /**
     * @return void
     */
    public function testUpdatePenguinCollectionReturnsCollectionWithOnePenguinEntityWhenEntityWasSaved(): void
    {
        // Arrange
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOnePersisted();
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->updatePenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertPenguinCollectionResponseContainsOneWithUuidOneTransferWithId($penguinCollectionResponseTransfer, $penguinTransfer);
    }

    /**
     * Tests that pre-update plugins are applied to entities.
     *
     * @return void
     */
    public function testUpdatePenguinCollectionAppliesPreUpdatePlugins(): void
    {
        // Arrange
        $this->tester->havePenguinPreUpdatePluginSetUuidTwoEnabled();
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOnePersisted();
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->updatePenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertPenguinCollectionResponseContainsOneWithUuidTwoTransferWithId($penguinCollectionResponseTransfer, $penguinTransfer);
    }

    /**
     * Tests that post-update plugins are applied to entities.
     *
     * @return void
     */
    public function testUpdatePenguinCollectionAppliesPostUpdatePlugins(): void
    {
        // Arrange
        $this->tester->havePenguinPostUpdatePluginSetUuidTwoEnabled();
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOnePersisted();
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->updatePenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertPenguinCollectionResponseContainsOneWithUuidTwoTransferWithId($penguinCollectionResponseTransfer, $penguinTransfer);
    }

    /**
     * Tests that entities are validated with internal ValidatorRuleInterface.
     *
     * @return void
     */
    public function testUpdatePenguinCollectionReturnsErroredCollectionResponseWhenValidationRuleFailed(): void
    {
        // Arrange
        $this->tester->havePenguinAlwaysFailingUpdateValidatorRuleEnabled(); // This will always return a validation error
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOnePersisted();
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->updatePenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertPenguinCollectionResponseContainsFailedValidationRuleError($penguinCollectionResponseTransfer);
    }

    /**
     * Tests that entities are validated with external ValidatorRulePluginInterface.
     *
     * @return void
     */
    public function testUpdatePenguinCollectionReturnsErroredCollectionResponseWhenValidationRulePluginFailed(): void
    {
        // Arrange
        $this->tester->havePenguinAlwaysFailingUpdateValidatorRulePluginEnabled(); // This will always return a validation error
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOnePersisted();
        $penguinCollectionRequestTransfer = new PenguinCollectionRequestTransfer();
        $penguinCollectionRequestTransfer->addPenguin($penguinTransfer);

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->updatePenguinCollection($penguinCollectionRequestTransfer);

        // Assert
        $this->tester->assertPenguinCollectionResponseContainsFailedValidationRuleError($penguinCollectionResponseTransfer);
    }

    /**
     * Test ensures to always get a Collection back even if no entity was deleted.
     *
     * @return void
     */
    public function testDeletePenguinReturnsEmptyCollectionWhenNoEntityMatchedByCriteria(): void
    {
        // Arrange
        $this->tester->havePenguinTransferWithUuidTwoPersisted();
        $penguinDeleteCriteriaTransfer = $this->tester->havePenguinDeleteCriteriaTransferWithUuidOneCriteria();

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->deletePenguinCollection($penguinDeleteCriteriaTransfer);

        // Assert
        $this->tester->assertPenguinCollectionResponseIsEmpty($penguinCollectionResponseTransfer);
    }

    /**
     * Test ensures to get a Collection with deleted entities back when criteria was matching.
     *
     * @return void
     */
    public function testDeletePenguinReturnsCollectionWithOnePenguinEntityWhenCriteriaMatched(): void
    {
        // Arrange
        $penguinTransfer = $this->tester->havePenguinTransferWithUuidOnePersisted();
        $penguinDeleteCriteriaTransfer = $this->tester->havePenguinDeleteCriteriaTransferWithUuidOneCriteria();

        // Act
        $penguinCollectionResponseTransfer = $this->tester->getFacade()->deletePenguinCollection($penguinDeleteCriteriaTransfer);

        // Assert
        $this->tester->assertPenguinCollectionResponseContainsOneWithUuidOneTransferWithId($penguinCollectionResponseTransfer, $penguinTransfer);
    }
}
