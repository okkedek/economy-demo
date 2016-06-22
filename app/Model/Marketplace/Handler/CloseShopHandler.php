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

namespace App\Model\Marketplace\Handler;

use App\Model\Marketplace\Command\CloseShop;

class CloseShopHandler extends BaseHandler
{
    public function __invoke(CloseShop $command)
    {
        $marketplaceId = $command->getMarketplaceId();
        $shopId        = $command->getShopId();
        $marketplace   = $this->load($marketplaceId);
        $marketplace->closeShop($shopId);

        $this->store($marketplace);
    }
}