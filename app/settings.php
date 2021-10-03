<?php
declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {

            return new Settings([
                'mode'                => $_SERVER['MODE'],
                'debug'               => (bool)$_SERVER['DEBUG'],
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'databasePath'        => $_SERVER['DB_PATH'],
                'databaseName'        => $_SERVER['DB_NAME'],
                'logger'              => [
                    'name'  => 'slim-app',
                    'path'  => isset($_SERVER['docker']) ? 'php://stdout' : __DIR__.'/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
            ]);
        },
    ]);
};
