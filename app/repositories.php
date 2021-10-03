<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Domain\Container\ContainerRepository as ContainerRepositoryInterface;
use App\Infrastructure\Persistence\Container\ContainerRepository;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        ContainerRepositoryInterface::class => function(ContainerInterface $c){
            $settings = $c->get(SettingsInterface::class);
            return  new ContainerRepository($c->get(\MongoLite\Client::class),$settings->get('databaseName'));
        },
    ]);
};
