<?php
use App\Middleware\AuthMiddleware;

// Public pages
$app->get('/', 'PublicController:index')->setName('public_home');
$app->get('/maintenance', 'PublicController:maintenance')->setName('public_maintenance');

// Authentification
$app->get('/auth-login', 'AuthController:signin')->setName('auth_signin');
$app->post('/auth-login', 'AuthController:signinPost');
$app->get('/auth-logout', 'AuthController:signout')->setName('auth_signout');

$app->group('/admin', function (){
    // Admin pages
    $this->get('/', 'AdminController:index')->setName('admin_home');
    $this->get('/trystyle', 'AdminController:trystyle')->setName('admin_trystyle');

    // User
    $this->group('/user', function () {
        $this->get('', 'UserController:index')->setName('admin_user_list');
        $this->get('/new', 'UserController:new')->setName('admin_user_new');
        $this->post('/new', 'UserController:create');
        $this->get('/{id:[0-9]+}', 'UserController:show')->setName('admin_user_show');
        $this->get('/{id:[0-9]+}/edit', 'UserController:edit')->setName('admin_user_edit');
        $this->post('/{id:[0-9]+}/edit', 'UserController:update');
        $this->get('/{id:[0-9]+}/delete', 'UserController:delete')->setName('admin_user_delete');
    });

    // Medias
    $this->group('/media', function () {
        $this->get('', 'MediaController:index')->setName('admin_media_list');
        $this->get('/upload', 'MediaController:upload')->setName('admin_media_upload');
        $this->post('/upload', 'MediaController:save');
        $this->get('/{id:[0-9]+}/delete', 'MediaController:delete')->setName('admin_media_delete');
    });

    // Setting
    $this->get('/setting', 'SettingController:index')->setName('admin_setting');
    $this->post('/setting', 'SettingController:save');

    // Redirect
    $this->get('', function ($req, $res){
        return $res->withRedirect($this->router->pathFor('admin_home'));
    });
})->add(new AuthMiddleware($container));
