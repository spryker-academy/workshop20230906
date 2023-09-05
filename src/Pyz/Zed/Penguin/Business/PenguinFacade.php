<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business;

use Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;
use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;
use Generated\Shared\Transfer\PenguinCollectionTransfer;
use Generated\Shared\Transfer\PenguinCriteriaTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\Penguin\Business\PenguinBusinessFactory getFactory()
 * @method \Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface getRepository()
 * @method \Pyz\Zed\Penguin\Persistence\PenguinEntityManagerInterface getEntityManager()
 */
class PenguinFacade extends AbstractFacade implements PenguinFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinCriteriaTransfer $penguinCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionTransfer
     */
    public function getPenguinCollection(
        PenguinCriteriaTransfer $penguinCriteriaTransfer,
    ): PenguinCollectionTransfer {
        return $this->getFactory()->createPenguinReader()->getPenguinCollection($penguinCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function createPenguinCollection(
        PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer,
    ): PenguinCollectionResponseTransfer {
        return $this->getFactory()->createPenguinCreator()->createPenguinCollection($penguinCollectionRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function updatePenguinCollection(PenguinCollectionRequestTransfer $penguinCollectionRequestTransfer): PenguinCollectionResponseTransfer
    {
        return $this->getFactory()->createPenguinUpdater()->updatePenguinCollection($penguinCollectionRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function deletePenguinCollection(
        PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer,
    ): PenguinCollectionResponseTransfer {
        return $this->getFactory()->createPenguinDeleter()->deletePenguinCollection($penguinCollectionDeleteCriteriaTransfer);
    }
}
