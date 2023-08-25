<?php

declare(strict_types=1);

return function (\Slim\App $app) {
    // User CRUD
    $app->group('/user', function (\Slim\Interfaces\RouteCollectorProxyInterface $router) {
        $router->post('', \App\Application\Actions\User\Create::class);
        $router->get('s', \App\Application\Actions\User\ReadList::class);
        $router->group('/{id:[0-9]+}', function (\Slim\Interfaces\RouteCollectorProxyInterface $router) {
            $router->get('', \App\Application\Actions\User\Read::class);
            $router->put('', \App\Application\Actions\User\Update::class);
            $router->delete('', \App\Application\Actions\User\Delete::class);

            // User Position History Route
            $router->get('/position-history', \App\Application\Actions\User\Position\History::class);
        });
    });

    // Position CRUD
    $app->group('/position', function (\Slim\Interfaces\RouteCollectorProxyInterface $router) {
        $router->post('', \App\Application\Actions\Position\Create::class);
        $router->get('s', \App\Application\Actions\Position\ReadList::class);
        $router->group('/{code:[A-z0-9_-]+}', function (\Slim\Interfaces\RouteCollectorProxyInterface $router) {
            $router->get('', \App\Application\Actions\Position\Read::class);
            $router->put('', \App\Application\Actions\Position\Update::class);
            $router->delete('', \App\Application\Actions\Position\Delete::class);
        });
    });

    // Position History CRUD
    $app->group('/position-histor', function (\Slim\Interfaces\RouteCollectorProxyInterface $router) {
        $router->post('y', \App\Application\Actions\PositionHistory\Create::class);
        $router->get('ies', \App\Application\Actions\PositionHistory\ReadList::class);
        $router->group('y/{id:[0-9]+}', function (\Slim\Interfaces\RouteCollectorProxyInterface $router) {
            $router->get('', \App\Application\Actions\PositionHistory\Read::class);
            $router->put('', \App\Application\Actions\PositionHistory\Update::class);
            $router->delete('', \App\Application\Actions\PositionHistory\Delete::class);
        });
    });
};
