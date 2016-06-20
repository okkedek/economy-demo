<?php

namespace App\Console\Commands;

use App\Model\Common\MarketplaceId;
use App\Model\Marketplace\Command\AddMarketplace;
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

        $command = OpenShop::create(MarketplaceId::theOnlyOne(), 'bike', 10);
        $bus->dispatch($command);
    }
}
