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

namespace App\Model\Common;

use Rhumsaa\Uuid\Uuid;

class MarketplaceId extends AbstractId
{
    public function __construct($uuid = "f65a814b-3ece-456f-bbce-2ddf4681107f")
    {
        $this->id = Uuid::fromString($uuid);
    }

    public static function theOnlyOne()
    {
        return new MarketplaceId();
    }

    public static function random()
    {
        $marketplaceId = new MarketplaceId();
        $marketplaceId->id = Uuid::uuid4();
        
        return $marketplaceId;
    }
}