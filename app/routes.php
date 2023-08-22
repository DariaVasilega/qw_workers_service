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
        });
    });
};
