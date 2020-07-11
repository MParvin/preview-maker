<?php

namespace Core;

use DI\Container;
use DI\ContainerBuilder;
use Symfony\Component\Console\Application;

class ConsoleApplication extends Application
{
    protected $config;

    private $container;

    public function init(array $config)
    {
        $this->config = $config;

        return $this
            ->createContainer(isset($config['services']) ? $config['services'] : [])
            ->registerCommands();
    }

    private function registerCommands()
    {
        $commands = isset($this->config['commands']) ? $this->config['commands'] : [];

        // Register console commands
        foreach ($commands as $command) {
            $this->add(new $command);
        }

        return $this;
    }

    private function createContainer(array $services)
    {
        // Create container
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(false);
        $containerBuilder->useAnnotations(false);
        $containerBuilder->addDefinitions($services);

        // Set container
        $this->container = $containerBuilder->build();

        return $this;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getService($name, $params = [])
    {
        $container = $this->getContainer();
        $factory   = $container->get($name);

        return $factory->make($name, $params);
    }
}
