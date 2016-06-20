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

use Prooph\EventStore\Container\Aggregate\AggregateRepositoryFactory;

class EventSourceMarketplaceRepositoryFactory extends AggregateRepositoryFactory
{
    public function __construct()
    {
        parent::__construct('marketplace_repository');
    }

}