<?php

namespace Module\Application\Factory;

use DI\FactoryInterface;
use Module\Application\Service\ffmpegService;

class ffmpegServiceFactory extends AbstractFactory implements FactoryInterface
{
    public function make($name, array $parameters = [])
    {
        return new ffmpegService($parameters);
    }
}
