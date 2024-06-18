<?php

use DI\Container;
use League\Plates\Engine;
use Advvm\Repositories\Report\ReportRepositoryInterface;
use Advvm\Repositories\Report\ReportRepository;
use CoffeeCode\Router\Router;

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
];
