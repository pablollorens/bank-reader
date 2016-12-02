<?php

namespace BankReader\Core;

use Interop\Container\ContainerInterface;

class Container extends \Slim\Container
{
    public function __construct(array $values)
    {
        parent::__construct($values);
    }

    public function add($name, $value)
    {
        $this->offsetSet($name, $value);
    }
}
