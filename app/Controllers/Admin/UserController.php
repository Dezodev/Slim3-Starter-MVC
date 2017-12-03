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
            'name' => v::notEmpty()->alpha(),
            'email' => v::noWhitespace()->notEmpty()->email(),
            'password' => v::notEmpty(),
        ]);
        
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('admin_user_new'));
        }
            

        $user = User::create([
            'name' => $request->getParam('name'),
            'email' => $request->getParam('email'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        ]);
        
        return $response->withRedirect($this->router->pathFor('admin_user_list'));
    }
}