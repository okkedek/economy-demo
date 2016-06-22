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

use App\Model\Common\MarketplaceId;
use App\Model\Marketplace\Event\MarketplaceWasAdded;
use App\Model\Marketplace\Event\ShopWasClosed;
use App\Model\Marketplace\Event\ShopWasOpened;
use App\Model\Marketplace\Exception\ConsumerNotFoundException;
use App\Model\Marketplace\Exception\ShopNotFoundException;
use App\Model\Common\ConsumerId;
use App\Model\Common\ShopId;
use Illuminate\Support\Collection;
use Prooph\EventSourcing\AggregateRoot;

final class Marketplace extends AggregateRoot
{
    /**
     * @var MarketplaceId
     */
    protected $marketplaceId;
    
    /**
     * @var Collection
     */
    protected $consumers;

    /**
     * @var Collection
     */
    protected $shops;

    protected function __construct()
    {
        $this->consumers = new Collection();
        $this->shops = new Collection();
    }

    /**
     * Factory method: instantiates a new marketplace
     * 
     * @param MarketplaceId $marketplaceId
     * @return Marketplace
     */
    public static function createMarketplace(MarketplaceId $marketplaceId)
    {
        $marketplace = new self();
        $marketplace->recordThat(MarketplaceWasAdded::create($marketplaceId));
        
        return $marketplace;
    }

    public function whenMarketplaceWasAdded(MarketplaceWasAdded $event)
    {
        $this->marketplaceId = $event->getMarketplaceId();
    }

    /**
     * Performs a transaction between a consumer and a shop. The consumer
     * will provide tokens to the shop, for which the shop will give products
     * in return. Every product costs one token, so the total amount of
     * tokens + products will remain the same.
     * 
     * @param ConsumerId $consumerId
     * @param ShopId $shopId
     * @param $amount
     * @throws ConsumerNotFoundException
     * @throws ShopNotFoundException
     */
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

    /**
     * Adds a shop to the marketplace
     * 
     * @param $shopId
     * @param $productName
     * @param $amount
     */
    public function openShop($shopId, $productName, $amount)
    {
        $this->recordThat(ShopWasOpened::create($this->marketplaceId, $shopId, new Product($productName, $amount)));
    }

    public function whenShopWasOpened(ShopWasOpened $event)
    {
        $shop = new Shop($event->getShopId(), $event->getProduct());
        $this->shops->put((string)$shop->getId(), $shop);
    }

    /**
     * Closes a shop
     * 
     * @param ShopId $shopId
     */
    public function closeShop(ShopId $shopId)
    {
        $this->recordThat(ShopWasClosed::create($this->marketplaceId, $shopId));
    }

    public function whenShopWasClosed(ShopWasClosed $event)
    {
        $shopId = (string)$event->getShopId();
        $shop   = $this->shops->get($shopId);
        $shop->close();
        $this->shops->forget($shopId);
    }    

    /**
     * Lets a consumer enter the marketplace
     * 
     * @param $consumerName
     * @param $tokenAmount
     * @return mixed
     */
    public function enterMarket($consumerName, $tokenAmount)
    {
        $consumer = new Consumer(new ConsumerId(), $consumerName, new Token($tokenAmount));
        $this->consumers->put((string)$consumer->getId(), $consumer);

        return $consumer->getId();
    }

    /**
     * Lets a consumer leave the marketplace
     * 
     * @param ConsumerId $consumerId
     */
    public function leaveMarket(ConsumerId $consumerId)
    {
        $this->consumers->forget((string)$consumerId);
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

    /**
     * @return string representation of the unique identifier of the aggregate root
     */
    protected function aggregateId()
    {
        return (string)$this->marketplaceId;
    }
}