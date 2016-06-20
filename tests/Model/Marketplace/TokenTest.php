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

use App\Model\Marketplace\Token;

class TokenTest extends \PHPUnit_Framework_TestCase
{
    public function testTokenAmountCanBeSplit()
    {
        $token = new Token(10);
        $part = $token->take(3);
        $remainder = $token->substract(3);

        $this->assertEquals($part, new Token(3));
        $this->assertEquals($remainder, new Token(7));
    }
}
