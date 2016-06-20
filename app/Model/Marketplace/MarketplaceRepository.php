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

namespace App\Model\Marketplace;

use App\Model\Common\MarketplaceId;

interface MarketplaceRepository
{
    /**
     * @param MarketplaceId $marketplaceId
     * @return Marketplace
     */
    public function get(MarketplaceId $marketplaceId);

    /**
     * @param Marketplace $marketplace
     */
    public function store(Marketplace $marketplace);

    public function generateNextMarketplaceId();

    public function generateNextShopId();
    
    public function generateNextConsumerId();
}