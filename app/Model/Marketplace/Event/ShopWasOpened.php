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
use App\Model\Marketplace\Product;
use Prooph\EventSourcing\AggregateChanged;

final class ShopWasOpened extends AggregateChanged
{
    private $marketplaceId;
    private $shopId;
    private $product;

    public function getMarketplaceId()
    {
        if (is_null($this->marketplaceId)) {
            $this->marketplaceId = new MarketplaceId($this->payload['marketplace_id']);
        }
        return $this->marketplaceId;
    }

    public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = new Product($this->payload['product_name'],$this->payload['product_amount']);
        }

        return $this->product;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public static function create(MarketplaceId $marketplaceId, ShopId $shopId, Product $product)
    {
        $event = self::occur((string)$marketplaceId, [
            'marketplace_id' => (string)$marketplaceId,
            'shop_id' => (string)$shopId,
            'product_name' => $product->getName(),
            'product_amount' => $product->getAmount(),
        ]);

        $event->marketplaceId = $marketplaceId;
        $event->shopId = $shopId;
        $event->product = $product;

        return $event;
    }    

}