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

namespace App\Model\Marketplace\Command;


use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

final class CloseShop extends Command implements PayloadConstructable
{
    use PayloadTrait;

    /**
     * @param $marketplaceId
     * @param $shopId
     * @return OpenShop
     */
    public static function create($marketplaceId, $shopId)
    {
        return new self(compact('marketplaceId', 'shopId'));
    }

    public function getMarketplaceId()
    {
        return $this->payload['marketplaceId'];
    }

    public function getShopId()
    {
        return $this->payload['shopId'];
    }
}