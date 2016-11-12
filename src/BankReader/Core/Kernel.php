<?php

namespace BankReader\Core;

use BankReader\File\Parser;
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
        $parser = new Parser($container);
        $container->addService('parser', $parser);

        $transactions = $parser->parse();

        $container->addService('transactions', $transactions);

        $container->addService('categories', $parameters['categories']);

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
