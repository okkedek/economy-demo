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

    public function onShopWasOpened(ShopWasOpened $event)
    {
        $stat = $this->statistics->findById($event->getMarketplaceId());

        if (!$stat) {
            $this->connection
                ->table(MarketplaceStatistics::TABLE)
                ->insert([
                    'aggregate_id' => (string)$event->getMarketplaceId(),
                    'shops_count' => 1,
                ]);
        } else {
            $this->connection
                ->table(MarketplaceStatistics::TABLE)
                ->update([
                    'aggregate_id' => (string)$event->getMarketplaceId(),
                    'shops_count' => $stat->shops_count + 1,
                ]);

        }
    }
}