<?php

namespace App\Console\Commands;

use App\Model\Common\MarketplaceId;
use App\Model\Common\ShopId;
use App\Model\Marketplace\Command\AddMarketplace;
use App\Model\Marketplace\Command\CloseShop;
use App\Model\Marketplace\Command\OpenShop;
use Illuminate\Console\Command;
use Prooph\ServiceBus\CommandBus;

class Economy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'economy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the economy';

    /**
     * Execute the console command.
     *
     * @param CommandBus $bus
     * @return mixed
     */
    public function handle(CommandBus $bus)
    {
        $command = AddMarketplace::create();
        $bus->dispatch($command);

        $shopId = new ShopId();
        $command = OpenShop::create(MarketplaceId::theOnlyOne(), $shopId, 'bike', 10);
        $bus->dispatch($command);

        $command = CloseShop::create(MarketplaceId::theOnlyOne(), $shopId);
        $bus->dispatch($command);
    }
}
