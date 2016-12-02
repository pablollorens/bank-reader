<?php

namespace BankReader\Core;

use BankReader\Data\Loader;
use Slim\App;
use Symfony\Component\Yaml\Yaml;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_Debug;

abstract class Kernel extends App implements KernelInterface
{
    public function __construct(Container $container)
    {
        parent::__construct($container);

        $parameters = Yaml::parse(file_get_contents($container->get('parameters_file')));
        $container->add('parameters', $parameters);

        // Load Twig
        $loader = new Twig_Loader_Filesystem($this->getRootDir() . '/app/Resources/views');
        $twig = new Twig_Environment($loader, array(
            'debug' => true,
            //'cache' => $this->getRootDir() . '/var/cache',
        ));

        $twig->addExtension(new Twig_Extension_Debug());

        $container->add('twig', $twig);

        // Load Transactions
        $transactions = Loader::fromExcelFiles($container, $parameters, $this->getRootDir());

        $container->add('transactions', $transactions);
    }
}
