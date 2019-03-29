<?php

$loader = require __DIR__ . '/vendor/autoload.php';

$loader->addPsr4('Model\\', __DIR__ . '/classes/Model');
$loader->addPsr4('Controller\\', __DIR__ . '/classes/Controller');
$loader->addPsr4('Core\\', __DIR__ . '/classes/Core');

$router = Core\Router::getInstance();

new Controller\IndexPage\Controller;
new Controller\API\Controller;


$router->start();
