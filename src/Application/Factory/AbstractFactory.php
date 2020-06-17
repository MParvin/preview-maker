<?php

namespace Module\Application\Factory;

use DI\FactoryInterface;

class AbstractFactory
{
    public function __call($method, $args)
    {
        return call_user_func_array([$this, $method], $args);
    }
}
