<?php

namespace Module\Application\Factory;

use DI\FactoryInterface;

class AbstractFactory
{
    private $config = [];

    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }
}
