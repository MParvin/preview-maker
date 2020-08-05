<?php

namespace Core;

use DI\Container;
use DI\ContainerBuilder;
use Module\Application\Exception\RequirementsException;
use Symfony\Component\Console\Application;
use Symfony\Component\Process\Process;

class ConsoleApplication extends Application
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Container
     */
    private $container;

    /**
     * Initialize application
     *
     * @param  mixed $config
     * @return void
     */
    public function init(array $config)
    {
        $this->config = $config;

        // Set application name and version
        $this->setName(isset($config['AppName']) ? $config['AppName'] : 'PreviewMaker');
        $this->setVersion(isset($config['version']) ? $config['version'] : '1.0.0');

        try {
            return $this
                ->checkRequirements()
                ->createContainer(isset($config['services']) ? $config['services'] : [])
                ->registerCommands();
        } catch (RequirementsException $e) {
            echo PHP_EOL;
            echo $e->getMessage();
            echo PHP_EOL;
            echo PHP_EOL;
            exit();
        }
    }

    public function getVersion()
    {
        return 'v' . parent::getVersion();
    }

    /**
     * Check the application requirements before running
     *
     * @throws RequirementsException
     * @return self
     */
    private function checkRequirements()
    {
        // Check OS environment
        if (PHP_OS != 'Linux') {
            throw new RequirementsException("Operating system is not supported. The program only runs on Linux server.");
        }

        // Check PHP version
        if (PHP_VERSION < '7.2.5') {
            throw new RequirementsException("Your PHP version is not supported. The application requires minimum 7.2.5 PHP version.");
        }

        // Check if java has been installed
        $process = Process::fromShellCommandline('java -version > NULL && echo yes || echo no');
        $process->run();
        if (!$process->isSuccessful() || trim($process->getOutput()) == 'no') {
            throw new RequirementsException('There is no Java environment.');
        }

        // Check if liberoffice has been installed
        $process = Process::fromShellCommandline('libreoffice --version > NULL && echo yes || echo no');
        $process->run();
        if (!$process->isSuccessful() || trim($process->getOutput()) == 'no') {
            throw new RequirementsException('LibreOffice has not been installed.');
        }

        return $this;
    }

    /**
     * Register available commands
     *
     * @return self
     */
    private function registerCommands()
    {
        $commands = isset($this->config['commands']) ? $this->config['commands'] : [];

        // Register console commands
        foreach ($commands as $command) {
            $this->add(new $command);
        }

        return $this;
    }

    /**
     * Create dependency injection container
     *
     * @param  mixed $services
     * @return self
     */
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

    /**
     * Get container
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get a service by its name
     *
     * @param  string $name   Service name
     * @param  mixed  $params
     * @return object
     */
    public function getService($name, $params = [])
    {
        $container = $this->getContainer();
        $factory   = $container->get($name);

        return $factory->setConfig($this->config)->make($name, $params);
    }
}
