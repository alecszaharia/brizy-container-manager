<?php
declare(strict_types=1);

use App\Application\Actions\Container\CreateContainerAction;
use App\Application\Actions\Container\DeleteContainerAction;
use App\Application\Actions\Container\ListContainerAction;
use App\Application\Actions\Container\RunContainerInstanceAction;
use App\Application\Actions\Container\UpdateContainerAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->group('/containers', function (Group $group) {
        $group->get('', ListContainerAction::class);
        $group->post('', CreateContainerAction::class);
        $group->put('/{_id}', UpdateContainerAction::class);
        $group->delete('/{_id}', DeleteContainerAction::class);
    });

    $app->get('/{resource:.*}', RunContainerInstanceAction::class);

};
