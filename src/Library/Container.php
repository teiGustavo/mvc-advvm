<?php

namespace Advvm\Library;

use DI\Container as DIContainer;
use DI\ContainerBuilder;

use function DI\autowire;

class Container
{
    public readonly DIContainer $container;
    private array $services;

    public function build(array $services = []): DIContainer
    {
        $this->load($services);
        $container = new ContainerBuilder();
        $container->addDefinitions(...$this->services);

        return $container->build();
    }

    public function bind(string $interface, string $class): void
    {
        $default = dirname(__FILE__, 2) . '/Services/services.php';
        $this->services[] = $default;
        $this->services[] = [$interface => autowire($class)];
    }

    private function load(array $services): void
    {
        if (!empty($services)) {
            foreach ($services as $service) {
                $this->services[] = dirname(__FILE__, 2) . "/Services/{$service}.php";
            }
        }
    }
}
