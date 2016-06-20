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

namespace Model\Marketplace\Handler;


use App\Model\Common\MarketplaceId;
use App\Model\Common\ShopId;
use App\Model\Marketplace\Command\OpenShop;
use App\Model\Marketplace\Handler\OpenShopHandler;
use App\Model\Marketplace\Marketplace;
use App\Model\Marketplace\MarketplaceRepository;
use Illuminate\Contracts\Logging\Log;
use Mockery as m;
use TestCase;

class OpenShopHandlerTest extends TestCase
{
    public function testItHandlesTheCommand()
    {
        $randomMarketplaceId = MarketplaceId::random();
        $repository = m::mock(MarketplaceRepository::class);
        $repository
            ->shouldReceive('get')->once()
            ->andReturn(Marketplace::createMarketplace($randomMarketplaceId));
        $repository
            ->shouldReceive('generateNextShopId')->once()
            ->andReturn(new ShopId());
        $repository
            ->shouldReceive('store')->once();

        $log = $this->app->make(Log::class);

        $command = OpenShop::create($randomMarketplaceId, 'bike', 10);
        $handler = new OpenShopHandler($repository , $log);
        $handler($command);
    }
}
