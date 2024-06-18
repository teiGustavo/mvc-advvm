<?php

namespace Advvm\Library;

use DI\Container as DIContainer;
use DI\ContainerBuilder;

use function DI\autowire;

class Container
{
    public readonly DIContainer $container;
    private array $services;

    public function build(array $services = [])
    {
        $this->load($services);
        $container = new ContainerBuilder();
        $container->addDefinitions(...$this->services);

        return $container->build();
    }

    public function bind(string $interface, string $class)
    {
        $default = dirname(__FILE__, 2) . '/Services/services.php';
        $this->services[] = $default;
        $this->services[] = [$interface => autowire($class)];
    }

    private function load(array $services)
    {
        if (!empty($services)) {
            foreach ($services as $service) {
                $this->services[] = dirname(__FILE__, 3) . "/app/services/{$service}.php";
            }
        }
    }
}