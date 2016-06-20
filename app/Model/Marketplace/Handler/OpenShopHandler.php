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

use App\Model\Marketplace\Command\OpenShop;
use App\Model\Marketplace\MarketplaceRepository;
use Illuminate\Contracts\Logging\Log;

class OpenShopHandler
{
    private $marketplaceRepository;
    
    public function __construct(MarketplaceRepository $marketplaceRepository, Log $log)
    {
        $this->marketplaceRepository = $marketplaceRepository;
        $log->info('test');
    }

    public function __invoke(OpenShop $command)
    {
        $marketplaceId = $command->getMarketplaceId();
        $marketplace   = $this->marketplaceRepository->get($marketplaceId);
        $shopId        = $this->marketplaceRepository->generateNextShopId();
        $marketplace->openShop($shopId, $command->getProductName(), $command->getProductAmount());

        $this->marketplaceRepository->store($marketplace);
    }
}