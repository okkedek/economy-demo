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


use App\Model\Marketplace\Command\OpenShop;
use App\Model\Marketplace\Handler\OpenShopHandler;
use App\Model\Marketplace\MarketplaceRepository;
use Illuminate\Foundation\Testing\TestCase;

class OpenShopHandlerTest extends TestCase
{
    public function testItHandlesTheCommand()
    {
        /** @var MarketplaceRepository $marketplaceRepository */
        $marketplaceRepository = $this->app->make(MarketplaceRepository::class);
        $marketplace = $marketplaceRepository->get();

        $command = OpenShop::create('bike', 10);
        $handler = $this->app->make(OpenShopHandler::class);
        $handler($command);

        $this->assertEquals(10,$marketplace->getProductAmount());
    }

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }
}
