<?php

$container = $app->getContainer();

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

// Register controllers
$container['HomeController'] = function ($c) { return new \App\Controllers\HomeController($c); };