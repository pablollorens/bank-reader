<?php

require 'vendor/autoload.php';

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/Amsterdam');

$kernel = new AppKernel();

$container = $kernel->getContainer();

$mainController = new \BankReader\Controller\MainController($container);

echo $mainController->indexAction();

exit;
