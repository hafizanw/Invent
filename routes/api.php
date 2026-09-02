<?php

/** @var \Phalcon\Mvc\Router $router */

$router->add('/api/health', [
    'namespace'  => 'App\Controllers\Api',
    'controller' => 'api',
    'action'     => 'health',
]);
