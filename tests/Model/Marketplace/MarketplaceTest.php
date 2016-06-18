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

namespace Model\Marketplace;

use App\Model\Marketplace\Exception\ConsumerNotFoundException;
use App\Model\Marketplace\Exception\ShopNotFoundException;
use App\Model\Marketplace\Marketplace;
use App\Model\Common\ConsumerId;
use App\Model\Common\ShopId;

class MarketplaceTest extends \PHPUnit_Framework_TestCase
{

    public function testMarketplaceCanOpenAndCloseAShop()
    {
        $marketplace = Marketplace::createMarketplace();
        $shopId = new ShopId();
        $marketplace->openShop($shopId, 'bike', 10);
        $marketplace->closeShop($shopId);
    }

    public function testConsumerCanEnterAndLeaveMarketplace()
    {
        $marketplace = Marketplace::createMarketplace();
        $consumerId = $marketplace->enterMarket('John', 10);
        $marketplace->leaveMarket($consumerId);
    }

    public function testConsumerMustBeInMarketplaceWhenBuying()
    {
        $marketplace = Marketplace::createMarketplace();
        $shopId = new ShopId();
        $marketplace->openShop($shopId, 'bike', 10);

        $this->setExpectedException(ConsumerNotFoundException::class);
        $marketplace->tradeProductForToken(new ConsumerId(), $shopId, 5);

        $this->setExpectedException(null);
        $consumerId = $marketplace->enterMarket('John', 10);
        $marketplace->tradeProductForToken($consumerId, $shopId, 5);
        $marketplace->leaveMarket($consumerId);

        $this->setExpectedException(ConsumerNotFoundException::class);
        $marketplace->tradeProductForToken($consumerId, $shopId, 5);
    }

    public function testShopMustBeOpenWhenSelling()
    {
        $marketplace = Marketplace::createMarketplace();
        $consumerId = $marketplace->enterMarket('John', 10);

        $this->setExpectedException(ShopNotFoundException::class);
        $marketplace->tradeProductForToken($consumerId, new ShopId(), 5);

        $this->setExpectedException(null);
        $shopId = new ShopId();
        $marketplace->openShop($shopId, 'bike', 10);
        $marketplace->tradeProductForToken($consumerId, $shopId, 5);
    }

    public function testProductAndTokensAreExchangedDuringTrade()
    {
        $marketplace = Marketplace::createMarketplace();
        $consumerId = $marketplace->enterMarket('John', 10);
        $shopId = new ShopId();
        $marketplace->openShop($shopId, 'bike', 10);

        $marketplace->tradeProductForToken($consumerId, $shopId, 3);

        $this->assertEquals(10, $marketplace->getTokenAmount());
        $this->assertEquals(10, $marketplace->getProductAmount());
    }

    public function testAmountOfTokensAndProductsDoesNotChangeDuringTrade()
    {
        $marketplace = Marketplace::createMarketplace();
        $consumerJohnId = $marketplace->enterMarket('John', 10);
        $consumerMaraId = $marketplace->enterMarket('Maja', 10);
        $bikeShopId = new ShopId();
        $carShopId = new ShopId();
        $marketplace->openShop($bikeShopId, 'bike', 10);
        $marketplace->openShop($carShopId, 'car', 20);

        $marketplace->tradeProductForToken($consumerJohnId, $bikeShopId, 5);
        $marketplace->tradeProductForToken($consumerMaraId, $carShopId, 3);
        $marketplace->tradeProductForToken($consumerJohnId, $carShopId, 5);
        $marketplace->tradeProductForToken($consumerMaraId, $bikeShopId, 3);

        $this->assertEquals(30, $marketplace->getProductAmount());
        $this->assertEquals(20, $marketplace->getTokenAmount());
    }
}
