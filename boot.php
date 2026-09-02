<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Url as UrlProvider;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Router;

// Register Composer Autoloader
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Register PSR-4 fallback autoloader if vendor/autoload.php is not yet generated
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Create Dependency Injection Container
$di = new FactoryDefault();

// 1. Register Config Service
$config = require_once __DIR__ . '/konfigurasi.php';
$di->setShared('config', function () use ($config) {
    return $config;
});

// 2. Register Database Service (Local Host MySQL connection)
$di->setShared('db', function () use ($di) {
    $config = $di->getShared('config');
    return new DbAdapter([
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'port'     => $config->database->port,
        'charset'  => $config->database->charset,
    ]);
});

// 3. Register URL Provider Service
$di->setShared('url', function () use ($di) {
    $config = $di->getShared('config');
    $url = new UrlProvider();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

// 4. Register View Service
$di->setShared('view', function () use ($di) {
    $config = $di->getShared('config');
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);
    return $view;
});

// 5. Register Router Service
$di->setShared('router', function () {
    $router = new Router(false);
    $router->removeExtraSlashes(true);

    // Load web and api routes definitions
    require_once __DIR__ . '/routes/web.php';
    require_once __DIR__ . '/routes/api.php';

    return $router;
});

// Create and return Phalcon Application with DI container
$application = new Application($di);

return $application;
