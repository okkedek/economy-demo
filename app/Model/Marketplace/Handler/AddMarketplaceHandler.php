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
use App\Model\Marketplace\MarketplaceRepository;
use Illuminate\Contracts\Logging\Log;

class AddMarketplaceHandler
{
    private $marketplaceRepository;
    
    public function __construct(MarketplaceRepository $marketplaceRepository, Log $log)
    {
        $this->marketplaceRepository = $marketplaceRepository;
    }

    /**
     * Adds theOnlyOne marketplace if it doesn't exist yet
     * 
     * @param AddMarketplace $command
     */
    public function __invoke(AddMarketplace $command)
    {
        $marketplaceId = MarketplaceId::theOnlyOne();
        $marketplace   = $this->marketplaceRepository->get($marketplaceId);

        if ($marketplace == null) {
            $marketplace = Marketplace::createMarketplace($marketplaceId);
        }
        
        $this->marketplaceRepository->store($marketplace);
    }
}