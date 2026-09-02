<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

try {
    /** @var \Phalcon\Mvc\Application $app */
    $app = require_once __DIR__ . '/../boot.php';

    if (!$app instanceof \Phalcon\Mvc\Application) {
        throw new \RuntimeException(
            'boot.php tidak mengembalikan instance Phalcon\\Mvc\\Application.'
        );
    }

    $response = $app->handle($_SERVER['REQUEST_URI']);

    $response->send();

} catch (\Throwable $e) {
    http_response_code(500);

    echo '<h1>Internal Server Error</h1>';
    echo '<p><strong>Message:</strong> '
        . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')
        . '</p>';

    echo '<p><strong>File:</strong> '
        . htmlspecialchars($e->getFile(), ENT_QUOTES, 'UTF-8')
        . '</p>';

    echo '<p><strong>Line:</strong> '
        . $e->getLine()
        . '</p>';

    echo '<pre>'
        . htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8')
        . '</pre>';
}