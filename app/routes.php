<?php

$app->get('/', 'HomeController:index');

$app->group('/admin', function (){
    $this->get('/', 'AdminController:index');
});