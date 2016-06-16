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

namespace Domain\Repository\Marketplace;


use App\Model\Marketplace\Marketplace;

interface MarketplaceRepository
{
    public function findById($marketplaceId);

    public function store(Marketplace $marketplace);
}