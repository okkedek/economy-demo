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

namespace App\Infrastructure\Repository;


use App\Model\Common\ConsumerId;
use App\Model\Common\ShopId;
use App\Model\Marketplace\Marketplace;
use App\Model\Marketplace\MarketplaceRepository;

class MarketplaceRepositoryStub implements MarketplaceRepository
{
    /**
     * @var Marketplace
     */
    private $marketplace;

    /**
     * MarketplaceRepositoryStub constructor.
     */
    public function __construct()
    {
        $this->marketplace = Marketplace::createMarketplace();
    }

    /**
     * @return Marketplace
     */
    public function get()
    {
        return $this->marketplace;
    }

    /**
     * @param Marketplace $marketplace
     */
    public function store(Marketplace $marketplace)
    {
        $this->marketplace = $marketplace;
    }

    public function generateNextShopId()
    {
        return new ShopId();
    }

    public function generateNextConsumerId()
    {
        return new ConsumerId();
    }
}