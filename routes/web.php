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

$router->add('/ping', [
    'namespace'  => 'App\Controllers\Web',
    'controller' => 'index',
    'action'     => 'ping',
]);

$router->add('/ping/{name:[a-zA-Z]+}', [
    'namespace'  => 'App\Controllers\Web',
    'controller' => 'index',
    'action'     => 'ping',
]);
