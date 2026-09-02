<?php

try {
    /** @var \Phalcon\Mvc\Application $app */
    $app = require_once __DIR__ . '/../boot.php';

    $response = $app->handle($_SERVER['REQUEST_URI']);
    $response->send();
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Internal Server Error</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
