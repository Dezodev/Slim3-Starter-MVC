<?php

namespace App\Controllers;
use App\Models\User;

class AdminController extends Controller
{
    public function index($request, $response, $args)
    {        
        return $this->view->render($response, 'admin/index.twig');       
    }

    public function user_list($request, $response, $args)
    {        
        return $this->view->render($response, 'admin/user/index.twig');       
    }

    public function user_new($request, $response, $args)
    {        
        return $this->view->render($response, 'admin/user/new.twig');       
    }

    public function user_create($request, $response)
    {        
        $user = User::create([
            'name' => $request->getParam('name'),
            'email' => $request->getParam('email'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        ]);
        
        return $response->withRedirect($this->router->pathFor('admin_user_list'));
    }
}
