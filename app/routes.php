<?php

$app->get('/', 'HomeController:index')->setName('public_home');

$app->group('/admin', function (){
    $this->get('/', 'AdminController:index')->setName('admin_home');
    
    $this->get('/user', 'AdminController:user_list')->setName('admin_user_list');
    $this->get('/user/new', 'AdminController:user_new')->setName('admin_user_new');
    $this->post('/user/new', 'AdminController:user_create');

    $this->get('', function ($req, $res){
        return $res->withRedirect($this->router->pathFor('admin_home'));
    });
});