<?php

namespace BankReader\Core;

use BankReader\Data\Loader;
use Symfony\Component\Yaml\Yaml;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_Debug;

abstract class Kernel implements KernelInterface
{
    protected $container;

    public function __construct($parametersFile = '')
    {
        $container = new Container();

        $container->addService('kernel', $this);

        $parameters = Yaml::parse(file_get_contents($parametersFile));
        $container->addService('parameters', $parameters);

        // Load Twig
        $loader = new Twig_Loader_Filesystem($this->getRootDir() . '/app/Resources/views');
        $twig = new Twig_Environment($loader, array(
            'debug' => true,
            //'cache' => $this->getRootDir() . '/var/cache',
        ));

        $twig->addExtension(new Twig_Extension_Debug());

        $container->addService('twig', $twig);

        // Load Transactions
        $transactions = Loader::fromExcelFiles($container);

        $container->addService('transactions', $transactions);

        $this->container = $container;
    }

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }
}
