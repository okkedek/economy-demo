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


use App\Model\Marketplace\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{

    public function testProductAmountCanBeSplit()
    {
        $product = new Product("ananas",10);
        $part = $product->take(3);
        $remainder = $product->substract(3);

        $this->assertEquals($part, new Product('ananas', 3));
        $this->assertEquals($remainder, new Product('ananas', 7));
    }
}
