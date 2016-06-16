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

namespace Domain\Model\Marketplace;


use App\Model\Marketplace\Product;
use App\Model\Marketplace\Shop;
use App\Model\Marketplace\Token;
use Rhumsaa\Uuid\Uuid;

class ShopTest extends \PHPUnit_Framework_TestCase
{
    public function testShopCanSell()
    {
        $shop = new Shop(Uuid::uuid4(), new Product("bikes" , 8));
        $product = $shop->sellFor(new Token(2));

        $this->assertEquals(new Product('bikes',2), $product);

    }
}
