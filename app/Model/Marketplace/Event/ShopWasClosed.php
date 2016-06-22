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

namespace App\Model\Marketplace\Event;


use App\Model\Common\MarketplaceId;
use App\Model\Common\ShopId;
use Prooph\EventSourcing\AggregateChanged;

final class ShopWasClosed extends AggregateChanged
{
    private $marketplaceId;
    private $shopId;

    public function getMarketplaceId()
    {
        if (is_null($this->marketplaceId)) {
            $this->marketplaceId = new MarketplaceId($this->payload['marketplace_id']);
        }
        
        return $this->marketplaceId;
    }

    public function getShopId()
    {
        if (is_null($this->shopId)) {
            $this->shopId = ShopId::fromString($this->payload['shop_id']);
        }

        return $this->shopId;
    }

    public static function create(MarketplaceId $marketplaceId, ShopId $shopId)
    {
        $event = self::occur((string)$marketplaceId, [
            'marketplace_id' => (string)$marketplaceId,
            'shop_id' => (string)$shopId,
        ]);

        $event->marketplaceId = $marketplaceId;
        $event->shopId = $shopId;

        return $event;
    }

}