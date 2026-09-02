<?php

/** @var \Phalcon\Mvc\Router $router */

$router->add('/', [
    'namespace'  => 'App\Controllers\Web',
    'controller' => 'index',
    'action'     => 'index',
]);

$router->add('/db-check', [
    'namespace'  => 'App\Controllers\Web',
    'controller' => 'index',
    'action'     => 'dbCheck',
]);
