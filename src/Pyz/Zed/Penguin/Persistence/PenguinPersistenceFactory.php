<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Penguin\Persistence;

use Orm\Zed\Penguin\Persistence\SpyPenguinQuery;
use Pyz\Zed\Penguin\Persistence\Propel\Penguin\Mapper\PenguinMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\Penguin\PenguinConfig getConfig()
 * @method \Pyz\Zed\Penguin\Persistence\PenguinRepositoryInterface getRepository()
 * @method \Pyz\Zed\Penguin\Persistence\PenguinEntityManagerInterface getEntityManager()
 */
class PenguinPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Penguin\Persistence\SpyPenguinQuery
     */
    public function createPenguinQuery(): SpyPenguinQuery
    {
        return new SpyPenguinQuery();
    }

    /**
     * @return \Pyz\Zed\Penguin\Persistence\Propel\Penguin\Mapper\PenguinMapper
     */
    public function createPenguinMapper(): PenguinMapper
    {
        return new PenguinMapper();
    }
}
