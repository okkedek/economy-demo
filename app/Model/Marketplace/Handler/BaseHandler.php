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


use App\Model\Marketplace\Exception\MarketplaceNotFoundException;
use App\Model\Marketplace\Marketplace;
use App\Model\Marketplace\MarketplaceRepository;

class BaseHandler
{
    private $marketplaceRepository;

    public function __construct(MarketplaceRepository $marketplaceRepository)
    {
        $this->marketplaceRepository = $marketplaceRepository;
    }

    /**
     * @param $marketplaceId
     * @return Marketplace
     * @throws MarketplaceNotFoundException
     */
    protected function load($marketplaceId)
    {
        $marketplace = $this->marketplaceRepository->get($marketplaceId);
        if ($marketplace === false) {
            throw new MarketplaceNotFoundException();
        }
        
        return $marketplace;
    }

    /**
     * @param Marketplace $marketplace
     */
    protected function store(Marketplace $marketplace)
    {
        $this->marketplaceRepository->store($marketplace);
    }
    

}