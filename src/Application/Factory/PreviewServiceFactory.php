<?php

namespace Module\Application\Factory;

use DI\FactoryInterface;
use Module\Application\Service\PreviewService;

class PreviewServiceFactory extends AbstractFactory implements FactoryInterface
{
    public function make($name, array $parameters = [])
    {
        $config  = $this->getConfig();
        $options = isset($config['settings']) ? $config['settings'] : [];

        return new PreviewService($options);
    }

    
}
