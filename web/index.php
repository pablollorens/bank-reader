<?php

require '../vendor/autoload.php';

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/Amsterdam');

$container = new \BankReader\Core\Container(array());

$kernel = new AppKernel($container);

// Define app routes
$kernel->get('/', function ($request, $response, $args) {

    $mainController = new \BankReader\Controller\MainController($this);

    $result = $mainController->indexAction();

    return $response->write($result);
});

$kernel->get('/explore/{date}', function ($request, $response, $args) {

    $date = $request->getAttribute('date');

    $mainController = new \BankReader\Controller\MainController($this);

    $result = $mainController->exploreAction($date);

    return $result;
});

// Run app
$kernel->run();
