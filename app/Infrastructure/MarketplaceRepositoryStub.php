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

namespace App\Infrastructure;


use App\Model\Marketplace\Marketplace;
use Domain\Repository\Marketplace\MarketplaceRepository;

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

    public function findById($marketplaceId)
    {
        return $this->marketplace;
    }

    public function store(Marketplace $marketplace)
    {
        $this->marketplace = $marketplace;
    }
}