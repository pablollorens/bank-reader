<?php

use BankReader\Core\Kernel;

class AppKernel extends Kernel
{

    public function __construct()
    {
        parent::__construct(__DIR__ . '/config/parameters.yml');
    }

    public function getRootDir()
    {
        return __DIR__ . '/..';
    }
}