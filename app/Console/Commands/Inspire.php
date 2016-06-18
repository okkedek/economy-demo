<?php

namespace App\Console\Commands;

use App\Model\Marketplace\Command\OpenShop;
use Illuminate\Console\Command;
use Prooph\ServiceBus\CommandBus;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CommandBus $bus)
    {
        $command = OpenShop::create('bike',10);
        
        $bus->dispatch($command);
    }
}
