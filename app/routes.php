<?php
use App\Middleware\AuthMiddleware;

$app->get('/', 'HomeController:index')->setName('public_home');

$app->get('/auth-login', 'AuthController:signin')->setName('auth_signin');
$app->post('/auth-login', 'AuthController:signinPost');
$app->get('/auth-logout', 'AuthController:signout')->setName('auth_signout');

$app->group('/admin', function (){
    $this->get('/', 'AdminController:index')->setName('admin_home');

    $this->get('/trystyle', 'AdminController:trystyle')->setName('admin_trystyle');

    $this->group('/user', function () {
        $this->get('', 'UserController:index')->setName('admin_user_list');
        $this->get('/new', 'UserController:new')->setName('admin_user_new');
        $this->post('/new', 'UserController:create');
        $this->get('/{id:[0-9]+}', 'UserController:show')->setName('admin_user_show');
        $this->get('/{id:[0-9]+}/edit', 'UserController:edit')->setName('admin_user_edit');
        $this->post('/{id:[0-9]+}/edit', 'UserController:update');
        $this->get('/{id:[0-9]+}/delete', 'UserController:delete')->setName('admin_user_delete');
    });

    $this->get('', function ($req, $res){
        return $res->withRedirect($this->router->pathFor('admin_home'));
    });
})->add(new AuthMiddleware($container));
