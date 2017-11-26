<?php

$app->get('/', 'HomeController:index')->setName('public_home');

$app->group('/admin', function (){
    $this->get('/', 'AdminController:index')->setName('admin_home');

    $this->get('/trystyle', 'AdminController:trystyle')->setName('admin_trystyle');
    
    $this->get('/user', 'UserController:index')->setName('admin_user_list');
    $this->get('/user/new', 'UserController:new')->setName('admin_user_new');
    $this->post('/user/new', 'UserController:create');

    $this->get('', function ($req, $res){
        return $res->withRedirect($this->router->pathFor('admin_home'));
    });
});