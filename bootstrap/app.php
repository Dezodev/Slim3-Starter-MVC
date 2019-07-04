<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

define('SITE_ENV', 'developpment');

switch (SITE_ENV) {
    case 'developpment':
        $dotenv_name = '.env.dev';
        break;
    case 'production':
        $dotenv_name = '.env.prod';
        break;
    default:
        $dotenv_name = '.env.'.SITE_ENV;
        break;
}

$filename = __DIR__ .'/../'. $dotenv_name;

if (!file_exists($filename)) {
    trigger_error("Cannot find env file", E_USER_ERROR);
}

$dotenv = (new \Dotenv\Dotenv(__DIR__ . '/../', $dotenv_name))->load();

// Instantiate the app
$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . '/../app/dependencies.php';

// Register routes
require __DIR__ . '/../app/routes.php';
