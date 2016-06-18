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


use App\Model\Marketplace\Consumer;
use App\Model\Marketplace\Exception\InsufficientTokensException;
use App\Model\Marketplace\Exception\OutOfStockException;
use App\Model\Marketplace\Product;
use App\Model\Marketplace\Shop;
use App\Model\Marketplace\Token;
use PHPUnit_Framework_TestCase;
use Rhumsaa\Uuid\Uuid;

class ConsumerTest extends PHPUnit_Framework_TestCase
{

    public function testConsumerHoldsTokens()
    {
        $consumer = new Consumer(Uuid::uuid4(), "TestConsumer", new Token(4));
        $token = $consumer->getToken();

        $this->assertEquals(new Token(4) , $token);
    }

    public function testConsumerCanBuyProductFromShop()
    {
        $shop     = new Shop(Uuid::uuid4(), new Product("bikes" , 8));
        $consumer = new Consumer(Uuid::uuid4(), "TestConsumer", new Token(4));

        $product = $consumer->buyFromShop($shop , 3);
        $this->assertEquals(new Product('bikes',3), $product);
        $this->assertEquals(new Token(1), $consumer->getToken());

        $products = $consumer->getProducts();
        $this->assertEquals(new Product('bikes',3), $products[0]);
    }

    public function testConsumerCannotBuyWithInsufficientTokens()
    {
        $shop     = new Shop(Uuid::uuid4(), new Product("bikes" , 8));
        $consumer = new Consumer(Uuid::uuid4(), "TestConsumer", new Token(4));

        $this->setExpectedException(InsufficientTokensException::class);
        $consumer->buyFromShop($shop , 5);
    }

    public function testConsumerCannotBuyMoreThanAvailable()
    {
        $shop     = new Shop(Uuid::uuid4(), new Product("bikes" , 4));
        $consumer = new Consumer(Uuid::uuid4(), "TestConsumer", new Token(8));

        $this->setExpectedException(OutOfStockException::class);
        $consumer->buyFromShop($shop , 8);
    }
    
}
