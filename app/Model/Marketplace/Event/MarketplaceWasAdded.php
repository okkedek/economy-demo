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

namespace App\Model\Marketplace\Event;

use App\Model\Common\MarketplaceId;
use Prooph\EventSourcing\AggregateChanged;

final class MarketplaceWasAdded extends AggregateChanged
{
    private $marketplaceId;

    public static function create(MarketplaceId $marketplaceId)
    {
        $event = self::occur((string)$marketplaceId);

        $event->marketplaceId = $marketplaceId;

        return $event;
    }

    public function getMarketplaceId()
    {
        if (is_null($this->marketplaceId)) {
            $this->marketplaceId = MarketplaceId::fromString($this->aggregateId());
        }
        
        return $this->marketplaceId;
    }
}