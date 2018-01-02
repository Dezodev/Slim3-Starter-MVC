<?php

namespace App\Controllers;
use App\Models\User;

class AuthController extends Controller
{
    public function signin($request, $response, $args)
    {        
        return $this->view->render($response, 'auth/signin.twig');       
    }

    public function signinPost($request, $response, $args){
    	$auth = $this->auth->attempt(
    		$request->getParam('email'),
    		$request->getParam('password')
    	);

    	if (!$auth) {
    		return $response->withRedirect($this->router->pathFor('auth_signin'));
    	}
    	return $response->withRedirect($this->router->pathFor('admin_home'));
    }
}
