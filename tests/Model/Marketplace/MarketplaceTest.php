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

use App\Model\Common\MarketplaceId;
use App\Model\Marketplace\Exception\ConsumerNotFoundException;
use App\Model\Marketplace\Exception\ShopNotFoundException;
use App\Model\Marketplace\Marketplace;
use App\Model\Common\ConsumerId;
use App\Model\Common\ShopId;

class MarketplaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Marketplace
     */
    private $marketplace;

    public function setUp()
    {
        $this->marketplace = Marketplace::createMarketplace(MarketplaceId::theOnlyOne());
    }

    public function testMarketplaceCanOpenAndCloseAShop()
    {
        $shopId = new ShopId();
        $this->marketplace->openShop($shopId, 'bike', 10);
        $this->marketplace->closeShop($shopId);
    }

    public function testConsumerCanEnterAndLeaveMarketplace()
    {
        $consumerId = $this->marketplace->enterMarket('John', 10);
        $this->marketplace->leaveMarket($consumerId);
    }

    public function testConsumerMustBeInMarketplaceWhenBuying()
    {
        $shopId = new ShopId();
        $this->marketplace->openShop($shopId, 'bike', 10);

        $this->setExpectedException(ConsumerNotFoundException::class);
        $this->marketplace->tradeProductForToken(new ConsumerId(), $shopId, 5);

        $this->setExpectedException(null);
        $consumerId = $this->marketplace->enterMarket('John', 10);
        $this->marketplace->tradeProductForToken($consumerId, $shopId, 5);
        $this->marketplace->leaveMarket($consumerId);

        $this->setExpectedException(ConsumerNotFoundException::class);
        $this->marketplace->tradeProductForToken($consumerId, $shopId, 5);
    }

    public function testShopMustBeOpenWhenSelling()
    {
        $consumerId = $this->marketplace->enterMarket('John', 10);

        $this->setExpectedException(ShopNotFoundException::class);
        $this->marketplace->tradeProductForToken($consumerId, new ShopId(), 5);

        $this->setExpectedException(null);
        $shopId = new ShopId();
        $this->marketplace->openShop($shopId, 'bike', 10);
        $this->marketplace->tradeProductForToken($consumerId, $shopId, 5);
    }

    public function testProductAndTokensAreExchangedDuringTrade()
    {
        $consumerId = $this->marketplace->enterMarket('John', 10);
        $shopId = new ShopId();
        $this->marketplace->openShop($shopId, 'bike', 10);

        $this->marketplace->tradeProductForToken($consumerId, $shopId, 3);

        $this->assertEquals(10, $this->marketplace->getTokenAmount());
        $this->assertEquals(10, $this->marketplace->getProductAmount());
    }

    public function testAmountOfTokensAndProductsDoesNotChangeDuringTrade()
    {
        $consumerJohnId = $this->marketplace->enterMarket('John', 10);
        $consumerMaraId = $this->marketplace->enterMarket('Maja', 10);
        $bikeShopId = new ShopId();
        $carShopId = new ShopId();
        $this->marketplace->openShop($bikeShopId, 'bike', 10);
        $this->marketplace->openShop($carShopId, 'car', 20);

        $this->marketplace->tradeProductForToken($consumerJohnId, $bikeShopId, 5);
        $this->marketplace->tradeProductForToken($consumerMaraId, $carShopId, 3);
        $this->marketplace->tradeProductForToken($consumerJohnId, $carShopId, 5);
        $this->marketplace->tradeProductForToken($consumerMaraId, $bikeShopId, 3);

        $this->assertEquals(30, $this->marketplace->getProductAmount());
        $this->assertEquals(20, $this->marketplace->getTokenAmount());
    }
}
