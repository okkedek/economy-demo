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
namespace App\Infrastructure\Repository;

use App\Model\Common\MarketplaceId;
use App\Model\Common\ShopId;
use App\Model\Marketplace\Marketplace;
use App\Model\Marketplace\MarketplaceRepository;
use Prooph\EventStore\Aggregate\AggregateRepository;

class EventStoreMarketplaceRepository extends AggregateRepository implements MarketplaceRepository
{
    /**
     * @param MarketplaceId $marketplaceId
     * @return Marketplace
     */
    public function get(MarketplaceId $marketplaceId)
    {
        return $this->getAggregateRoot((string)$marketplaceId);
    }

    /**
     * @param Marketplace $marketplace
     */
    public function store(Marketplace $marketplace)
    {
        $this->addAggregateRoot($marketplace);
    }

    public function generateNextShopId()
    {
        return new ShopId();
    }

    public function generateNextMarketplaceId()
    {
        throw new \RuntimeException("Not implemented yet");
    }

    public function generateNextConsumerId()
    {
        throw new \RuntimeException("Not implemented yet");
    }
}