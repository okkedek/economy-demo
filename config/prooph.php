<?php
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/prooph/laravel-package for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/prooph/laravel-package/blob/master/LICENSE.md New BSD License
 */
// default example configuration for prooph components, see http://getprooph.org/
use App\Infrastructure\Repository\EventStoreMarketplaceRepository;
use App\Model\Marketplace\Command\AddMarketplace;
use App\Model\Marketplace\Command\CloseShop;
use App\Model\Marketplace\Command\OpenShop;
use App\Model\Marketplace\Event\MarketplaceWasAdded;
use App\Model\Marketplace\Event\ShopWasClosed;
use App\Model\Marketplace\Event\ShopWasOpened;
use App\Model\Marketplace\Handler\AddMarketplaceHandler;
use App\Model\Marketplace\Handler\CloseShopHandler;
use App\Model\Marketplace\Handler\OpenShopHandler;
use App\Model\Marketplace\Marketplace;
use App\Model\Marketplace\MarketplaceRepository;
use App\ReadModel\Marketplace\MarketplaceStatisticsProjector;

return [
    'event_store' => [
        'adapter' => [
            'type' => \Prooph\EventStore\Adapter\Doctrine\DoctrineEventStoreAdapter::class,
            'options' => [
                'connection_alias' => 'doctrine.connection.default',
            ],
        ],
        'plugins' => [
            \Prooph\EventStoreBusBridge\EventPublisher::class,
            \Prooph\EventStoreBusBridge\TransactionManager::class,
            \Prooph\Snapshotter\SnapshotPlugin::class,
        ],
        'marketplace_repository' => [
            'repository_class' => EventStoreMarketplaceRepository::class,
            'aggregate_type' => Marketplace::class,
            'aggregate_translator' => \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator::class,
            'snapshot_store' => \Prooph\EventStore\Snapshot\SnapshotStore::class,
        ],
        // list of aggregate repositories
    ],
    'service_bus' => [
        'command_bus' => [
            'router' => [
                'routes' => [
                    \Prooph\Snapshotter\TakeSnapshot::class => \Prooph\Snapshotter\Snapshotter::class,
                    AddMarketplace::class => AddMarketplaceHandler::class,
                    OpenShop::class => OpenShopHandler::class,
                    CloseShop::class => CloseShopHandler::class,
                    // list of commands with corresponding command handler
                ],
            ],
        ],
        'event_bus' => [
            'plugins' => [
                \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class
            ],
            'router' => [
                'routes' => [
                    // list of events with a list of projectors
                    MarketplaceWasAdded::class => MarketplaceStatisticsProjector::class,
                    ShopWasOpened::class => MarketplaceStatisticsProjector::class,
                    ShopWasClosed::class => MarketplaceStatisticsProjector::class,
                ],
            ],
        ],
    ],
    'snapshot_store' => [
        'adapter' => [
            'type' => \Prooph\EventStore\Snapshot\Adapter\Doctrine\DoctrineSnapshotAdapter::class,
            'options' => [
                'connection_alias' => 'doctrine.connection.default',
                'snapshot_table_map' => [
                    // list of aggregate root => table (default is snapshot)
                ]
            ]
        ]
    ],
    'snapshotter' => [
        'version_step' => 5, // every 5 events a snapshot
        'aggregate_repositories' => [
            Marketplace::class => MarketplaceRepository::class
            // list of aggregate root => aggregate repositories
        ]
    ],
];
