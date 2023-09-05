<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Communication\Console;

use Generated\Shared\Transfer\PenguinCollectionRequestTransfer;
use Generated\Shared\Transfer\PenguinTransfer;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Pyz\Zed\Penguin\Business\PenguinFacadeInterface getFacade()
 * @method \Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface getRepository()
 */
class PenguinCreatorConsole extends Console
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'penguin:create';

    /**
     * @var string
     */
    public const ARGUMENT_NAME = 'name';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName(static::COMMAND_NAME)
            ->setDescription('ADD DESCRIPTION HERE')
            ->addArgument(static::ARGUMENT_NAME, InputArgument::REQUIRED, 'Name of the penguin.');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $penguin = (new PenguinTransfer())
            ->setName($input->getArgument(static::ARGUMENT_NAME));
        $penguinCollectionRequestTransfer = (new PenguinCollectionRequestTransfer())
            ->addPenguin($penguin);

        $penguinCollection = $this->getFacade()->createPenguinCollection($penguinCollectionRequestTransfer);

        if (count($penguinCollection->getPenguins())) {
            return static::CODE_SUCCESS;
        }

        return static::CODE_ERROR;
    }
}
