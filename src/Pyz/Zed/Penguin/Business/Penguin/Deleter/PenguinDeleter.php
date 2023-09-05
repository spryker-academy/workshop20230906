<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Business\Penguin\Deleter;

use Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\PenguinCollectionResponseTransfer;
use Pyz\Zed\Penguin\Persistence\PenguinEntityManagerInterface;
use Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class PenguinDeleter implements PenguinDeleterInterface
{
    use TransactionTrait;

    /**
     * @var \Pyz\Zed\Penguin\Persistence\PenguinEntityManagerInterface
     */
    protected PenguinEntityManagerInterface $penguinEntityManager;

    /**
     * @var \Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface
     */
    protected PenguinRepositoryInterface $penguinRepository;

    /**
     * @param \Pyz\Zed\Penguin\Persistence\PenguinEntityManagerInterface $penguinEntityManager
     * @param \Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface $penguinRepository
     */
    public function __construct(
        PenguinEntityManagerInterface $penguinEntityManager,
        PenguinRepositoryInterface $penguinRepository,
    ) {
        $this->penguinEntityManager = $penguinEntityManager;
        $this->penguinRepository = $penguinRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    public function deletePenguinCollection(PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer): PenguinCollectionResponseTransfer
    {
        return $this->getTransactionHandler()->handleTransaction(function () use ($penguinCollectionDeleteCriteriaTransfer) {
            return $this->executeDeletePenguinCollectionTransaction($penguinCollectionDeleteCriteriaTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\PenguinCollectionResponseTransfer
     */
    protected function executeDeletePenguinCollectionTransaction(
        PenguinCollectionDeleteCriteriaTransfer $penguinCollectionDeleteCriteriaTransfer,
    ): PenguinCollectionResponseTransfer {
        $penguinCollectionTransfer = $this->penguinRepository->getPenguinDeleteCollection($penguinCollectionDeleteCriteriaTransfer);

        $penguinCollectionResponseTransfer = new PenguinCollectionResponseTransfer();

        foreach ($penguinCollectionTransfer->getPenguins() as $penguinTransfer) {
            $penguinCollectionResponseTransfer->addPenguin(
                $this->penguinEntityManager->deletePenguin($penguinTransfer),
            );
        }

        return $penguinCollectionResponseTransfer;
    }
}
