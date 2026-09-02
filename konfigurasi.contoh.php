<?php

use Phalcon\Config\Config;

return new Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => getenv('DB_HOST') ?: 'host.docker.internal',
        'username'    => getenv('DB_USERNAME') ?: 'root',
        'password'    => getenv('DB_PASSWORD') ?: '', 
        'dbname'      => getenv('DB_NAME') ?: 'invent',
        'port'        => getenv('DB_PORT') ?: 3306, # Sesuaikan dengan port MySQL Anda, defaultnya adalah 3306
        'charset'     => 'utf8mb4',
    ],
    'application' => [
        'appDir'         => __DIR__ . '/app/',
        'controllersDir' => __DIR__ . '/app/controllers/',
        'modelsDir'      => __DIR__ . '/app/models/',
        'viewsDir'       => __DIR__ . '/app/views/',
        'servicesDir'    => __DIR__ . '/app/services/',
        'validatorsDir'  => __DIR__ . '/app/validators/',
        'middlewareDir'  => __DIR__ . '/app/middleware/',
        'logsDir'        => __DIR__ . '/storage/logs/',
        'cacheDir'       => __DIR__ . '/storage/cache/',
        'baseUri'        => '/',
    ]
]);
