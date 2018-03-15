<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'prefix' => getenv('DB_PREFIX')
        ],
        // Only set this if you need access to route within middleware
        'determineRouteBeforeAppMiddleware' => true
    ],
];
