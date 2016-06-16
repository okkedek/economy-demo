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

namespace App\Model\Marketplace;

use App\Model\Marketplace\Exception\ConsumerNotFoundException;
use App\Model\Marketplace\Exception\ShopNotFoundException;
use App\Model\Common\ConsumerId;
use App\Model\Common\ShopId;
use Illuminate\Support\Collection;

final class Marketplace
{
    /**
     * @var Collection
     */
    protected $consumers;

    /**
     * @var Collection
     */
    protected $shops;

    private function __construct()
    {
        $this->consumers = new Collection();
        $this->shops = new Collection();
    }

    public function tradeProductForToken(ConsumerId $consumerId, ShopId $shopId, $amount)
    {
        if (!$this->consumers->has((string)$consumerId)) {
            throw new ConsumerNotFoundException();
        }
        if (!$this->shops->has((string)$shopId)) {
            throw new ShopNotFoundException();
        }

        $shop = $this->shops->get((string)$shopId);
        $consumer = $this->consumers->get((string)$consumerId);
        $consumer->buyFromShop($shop, $amount);
    }

    public function openShop($productName, $amount)
    {
        $shop = new Shop(new ShopId(), new Product($productName, $amount));
        $this->shops->put((string)$shop->getId(), $shop);

        return $shop->getId();
    }

    public function closeShop(ShopId $shopId)
    {
        $shop = $this->shops->get((string)$shopId);
        $shop->close();
        $this->shops->forget((string)$shopId);
    }

    public function enterMarket($consumerName, $tokenAmount)
    {
        $consumer = new Consumer(new ConsumerId(), $consumerName, new Token($tokenAmount));
        $this->consumers->put((string)$consumer->getId(), $consumer);

        return $consumer->getId();
    }

    public function leaveMarket(ConsumerId $consumerId)
    {
        $this->consumers->forget((string)$consumerId);
    }

    public static function createMarketplace()
    {
        return new self();
    }

    /**
     * Determines the total amount of tokens on the market
     *
     * @return int
     */
    public function getTokenAmount()
    {
        $totalToken = 0;
        foreach ($this->shops as $shop) {
            /** @var Shop $shop */
            $totalToken += $shop->getTokenAmount();
        }
        foreach ($this->consumers as $consumer) {
            /** @var Consumer $consumer */
            $totalToken += $consumer->getTokenAmount();
        }

        return $totalToken;
    }

    /**
     * Determines the total amount of product on the market
     *
     * @return int
     */
    public function getProductAmount()
    {
        $totalProduct = 0;
        foreach ($this->shops as $shop) {
            /** @var Shop $shop */
            $totalProduct += $shop->getProductAmount();
        }
        foreach ($this->consumers as $consumer) {
            /** @var Consumer $consumer */
            $totalProduct += $consumer->getProductAmount();
        }

        return $totalProduct;
    }


}