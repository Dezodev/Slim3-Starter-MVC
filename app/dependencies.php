<?php
use Respect\Validation\Validator as v;
use App\Models\Setting;

// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

$container = $app->getContainer();

// CSRF protection
$container['csrf'] = function ($c) {
    $guard = new \Slim\Csrf\Guard;
    $guard->setPersistentTokenMode(true);
    return $guard;
};

// Authentification
$container['auth'] = function ($c) {
    return new \App\Auth\Auth;
};

// Flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// Application logs
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('app_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

// Twig view
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../views', [
        'cache' => false,
        'debug' => true,
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));
    $view->addExtension(new App\Views\CsrfExtension($c['csrf']));
    $view->addExtension(new Twig_Extension_Debug());

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $c->auth->check(),
        'user' => $c->auth->user(),
    ]);
    $view->getEnvironment()->addGlobal('flash', $c['flash']);
    $view->getEnvironment()->addGlobal('app_settings', Setting::all()->keyBy('slug')->toArray());

    return $view;
};

// Validator
$container['validator'] = function () {
    return new App\Validation\Validator;
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
$container['PublicController'] = function ($c) {return new \App\Controllers\PublicController($c);};
$container['AdminController'] = function ($c) {return new App\Controllers\Admin\AdminController($c);};
$container['UserController'] = function ($c) {return new \App\Controllers\Admin\UserController($c);};
$container['AuthController'] = function ($c) {return new \App\Controllers\AuthController($c);};
$container['SettingController'] = function ($c) {return new \App\Controllers\Admin\SettingController($c);};
$container['MediaController'] = function ($c) {return new \App\Controllers\Admin\MediaController($c);};

// Variables
$container['upload_dir'] = __DIR__ . '/../uploads';
$container['upload_uri'] = '/uploads';

// Image manager
$container['imageManager'] = new ImageManager(array('driver' => 'imagick'));
$container['imageSizes'] = [
    [ '150', '150' ],
];

// Add Middleware
$app->add($container->get('csrf'));
$app->add(new App\Middleware\MaintenanceModeMiddleware($container));
$app->add(new App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\OldInputsMiddleware($container));

// Validate rules
v::with('App\\Validation\\Rules\\');
