<?php
/**
 *
 * This file is part of the okkedk/economy demo.
 * (c) 2016 i-Help Networks <okke@ihelp.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\Container\Infrastructure\Repository;


use App\Infrastructure\Repository\MarketplaceRepositoryStub;
use Interop\Container\ContainerInterface;

class MarketplaceRepositoryStubFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MarketplaceRepositoryStub();
    }
}