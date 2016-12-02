<?php

use BankReader\Core\Kernel;

use BankReader\Core\Container;

class AppKernel extends Kernel
{

    public function __construct(Container $container)
    {
        $container->add('parameters_file', __DIR__ . '/config/parameters.yml');
        parent::__construct($container);

    }

    public function getRootDir()
    {
        return __DIR__ . '/..';
    }
}
