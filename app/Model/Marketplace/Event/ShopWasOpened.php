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


use App\Model\Common\ShopId;
use App\Model\Marketplace\Product;
use Prooph\EventSourcing\AggregateChanged;

final class ShopWasOpened extends AggregateChanged
{
    private $shopId;
    private $product;

    public static function create(ShopId $shopId, Product $product)
    {
        $event = self::occur((string)$shopId, [
            'product_name' => $product->getName(),
            'product_amount' => $product->getAmount(),
        ]);

        $event->shopId = $shopId;
        $event->product = $product;

        return $event;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

}