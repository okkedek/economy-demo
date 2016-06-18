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

namespace Model\Marketplace\Command;


use App\Model\Marketplace\Command\OpenShop;

class OpenShopCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCommandStoresPayload()
    {
        $command = OpenShop::create('bike', 10);

        $this->assertEquals('bike', $command->getProductName());
        $this->assertEquals(10, $command->getProductAmount());
    }
}
