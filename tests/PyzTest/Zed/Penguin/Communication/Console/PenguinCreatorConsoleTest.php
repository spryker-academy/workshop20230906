<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Penguin\Communication\Console;

use Codeception\Test\Unit;
use Pyz\Zed\Penguin\Communication\Console\PenguinCreatorConsole;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Penguin
 * @group Communication
 * @group Console
 * @group PenguinCreatorConsoleTest
 * Add your own group annotations below this line
 */
class PenguinCreatorConsoleTest extends Unit
{
    /**
     * @var \PyzTest\Zed\Penguin\PenguinCommunicationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testExecutes(): void
    {
        $command = new PenguinCreatorConsole();
        $commandTester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
        ];

        $commandTester->execute($arguments);

        $this->assertSame(PenguinCreatorConsole::CODE_SUCCESS, $commandTester->getStatusCode());
    }
}
