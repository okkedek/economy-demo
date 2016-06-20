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

final class OpenShop extends Command implements PayloadConstructable
{
    use PayloadTrait;

    /**
     * @param $marketplaceId
     * @param $productName
     * @param $productAmount
     * @return OpenShop
     */
    public static function create($marketplaceId, $productName, $productAmount)
    {
        return new self(compact('marketplaceId', 'productName', 'productAmount'));
    }

    public function getMarketplaceId()
    {
        return $this->payload['marketplaceId'];
    }

    public function getProductName()
    {
        return $this->payload['productName'];
    }

    public function getProductAmount()
    {
        return $this->payload['productAmount'];
    }
}