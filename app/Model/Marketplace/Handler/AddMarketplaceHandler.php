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

use App\Model\Common\MarketplaceId;
use App\Model\Marketplace\Command\AddMarketplace;
use App\Model\Marketplace\Marketplace;

class AddMarketplaceHandler extends BaseHandler
{


    /**
     * Adds theOnlyOne marketplace if it doesn't exist yet
     * 
     * @param AddMarketplace $command
     */
    public function __invoke(AddMarketplace $command)
    {
        $marketplaceId = MarketplaceId::theOnlyOne();
        $marketplace   = $this->load($marketplaceId);
        if ($marketplace == null) {
            $marketplace = Marketplace::createMarketplace($marketplaceId);
        }
        
        $this->store($marketplace);
    }
}