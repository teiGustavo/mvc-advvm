<?php

use DI\Container;
use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Advvm\Repositories\Report\ReportRepositoryInterface;
use Advvm\Repositories\Report\ReportRepository;
use Advvm\Repositories\User\UserRepositoryInterface;
use Advvm\Repositories\User\UserRepository;

use function DI\autowire;

return [
    Router::class => function (Container $container) {
        return new Router(projectUrl: APP_URL, container: $container);
    },

    Engine::class => function (Container $container) {
        $dir = $dir ?? dirname(__FILE__, 3) . "/views/";

        return (new Engine($dir))->addData(['router' => $container->get(Router::class)]);
    },

    ReportRepositoryInterface::class => autowire(ReportRepository::class),
    UserRepositoryInterface::class => autowire(UserRepository::class),
];
