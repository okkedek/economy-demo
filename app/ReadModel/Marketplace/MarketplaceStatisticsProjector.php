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

namespace App\ReadModel\Marketplace;


use App\Model\Marketplace\Event\MarketplaceWasAdded;
use App\Model\Marketplace\Event\ShopWasClosed;
use App\Model\Marketplace\Event\ShopWasOpened;
use Illuminate\Database\Connection;

class MarketplaceStatisticsProjector
{
    /**
     * @var Connection
     */
    private $connection;

    /** @var MarketplaceStatistics */
    private $statistics;

    public function __construct(Connection $connection, MarketplaceStatistics $statistics)
    {
        $this->connection = $connection;
        $this->statistics = $statistics;
    }

    public function onMarketplaceWasAdded(MarketplaceWasAdded $event)
    {
        $this->connection
            ->table(MarketplaceStatistics::TABLE)
            ->insert([
                'aggregate_id' => (string)$event->getMarketplaceId(),
                'shops_count' => 0,
            ]);
    }

    public function onShopWasOpened(ShopWasOpened $event)
    {
        $stat = $this->statistics->findById($event->getMarketplaceId());

        $this->updateShopsCount($event->getMarketplaceId(), $stat->shops_count + 1);
    }

    public function onShopWasClosed(ShopWasClosed $event)
    {
        $stat = $this->statistics->findById($event->getMarketplaceId());

        $this->updateShopsCount($event->getMarketplaceId(), $stat->shops_count - 1);
    }

    protected function updateShopsCount($aggregateId, $value)
    {
        $this->connection
            ->table(MarketplaceStatistics::TABLE)
            ->update([
                'aggregate_id' => $aggregateId,
                'shops_count' => $value,
            ]);
    }
}