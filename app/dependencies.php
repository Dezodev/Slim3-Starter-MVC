<?php

$container = $app->getContainer();

// Twig view
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../views', [
        'cache' => false,
    ]);
    
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $basePath
    ));
    
    return $view;
};

// Database
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

// Register controllers
$container['HomeController'] = function ($c) { return new \App\Controllers\HomeController($c); };