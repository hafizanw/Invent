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

$router->add('/login-test', [
    'namespace'  => 'App\Controllers\Web',
    'controller' => 'index',
    'action'     => 'loginTest',
]);

$router->add('/login', [
    'namespace'  => 'App\Controllers\Web',
    'controller' => 'auth',
    'action'     => 'login',
])->via('GET');

$router->add('/login', [
    'namespace'  => 'App\Controllers\Web',
    'controller' => 'auth',
    'action'     => 'doLogin',
])->via('POST');

$router->add('/logout', [
    'namespace'  => 'App\Controllers\Web',
    'controller' => 'auth',
    'action'     => 'logout',
])->via('GET');