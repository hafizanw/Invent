<?php

use App\Middleware\AuthMiddleware;
use App\Services\AuthService;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;

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
    $url = new Url();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

$di->setShared('view', function () use ($di) {
    $config = $di->getShared('config');

    $view = new View();

    $view->setViewsDir(
        $config->application->viewsDir
    );

    return $view;
});

// 4. Register Session Service
$di->setShared('session', function () {
    $session = new SessionManager();

    $adapter = new SessionAdapter([
        'savePath' => __DIR__ . '/storage/sessions/',
    ]);

    $session->setAdapter($adapter);
    $session->start();

    return $session;
});

// 5. Register Middleware
$di->setShared('dispatcher', function () use ($di) {
    $eventsManager = new EventsManager();

    // Daftarkan AuthMiddleware untuk "mendengarkan" semua event bertipe 'dispatch'
    $eventsManager->attach('dispatch:beforeExecuteRoute', new AuthMiddleware());

    $dispatcher = new MvcDispatcher();
    $dispatcher->setDI($di);
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

// 6. Register authservice
$di->setShared('authService', function () use ($di) {
    $service = new AuthService();
    $service->setDI($di);   // tetap manual, karena kita bikin object sendiri di closure ini

    return $service;
});

// 7. Register Router Service
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
