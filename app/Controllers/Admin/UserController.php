<?php

namespace App\Controllers\Admin;
use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class UserController extends Controller
{
    public function index($request, $response, $args)
    {        
        $users = User::get();
        return $this->view->render($response, 'admin/user/index.twig', ['users' => $users]);       
    }

    public function new($request, $response, $args)
    {        
        return $this->view->render($response, 'admin/user/new.twig');       
    }

    public function create($request, $response)
    {        
        $validation = $this->validator->validate($request, [
            'username' => v::notEmpty()->alnum()->NoWhitespace()->usernameAvailable(),
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'password' => v::notEmpty()->length(6, null),
        ]);
        
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('admin_user_new'));
        }
            

        $user = User::create([
            'username' => $request->getParam('username'),
            'email' => $request->getParam('email'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        ]);
        
        return $response->withRedirect($this->router->pathFor('admin_user_list'));
    }
}