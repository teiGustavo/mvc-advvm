<?php

use DI\Container;
use League\Plates\Engine;
use Advvm\Repositories\ReportRepository;
use Advvm\Repositories\ReportRepositoryInterface;
use CoffeeCode\Router\Router;

use function DI\autowire;
use function DI\create;

return [
    Router::class => function (Container $container) {
        return new Router(projectUrl: APP_URL, container: $container);
    },

    Engine::class => function (Container $container) {
        $dir = $dir ?? dirname(__FILE__, 3) . "/views/";

        return (new Engine($dir))->addData(['router' => $container->get(Router::class)]);
    },

    ReportRepositoryInterface::class => autowire(ReportRepository::class),
];
