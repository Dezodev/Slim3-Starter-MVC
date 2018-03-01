<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => '172.16.238.12',
            'database' => 'slimstarter',
            'username' => 'dbuser',
            'password' => 'rootv66',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'prefix' => ''
        ],
        // Only set this if you need access to route within middleware
        'determineRouteBeforeAppMiddleware' => true
    ],
];
