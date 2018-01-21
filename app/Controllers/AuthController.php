<?php

namespace App\Controllers;
use App\Models\User;

class AuthController extends Controller
{
    public function signin($request, $response, $args) {
        return $this->view->render($response, 'auth/signin.twig');
    }

    public function signinPost($request, $response, $args){
    	$auth = $this->auth->attempt(
    		$request->getParam('email'),
    		$request->getParam('password')
    	);

    	if (!$auth) {
            $this->flash->addMessage('danger', 'Erreur : vous n\'avez pas pu être connecté.');
    		return $response->withRedirect($this->router->pathFor('auth_signin'));
    	}
    	return $response->withRedirect($this->router->pathFor('admin_home'));
    }

    public function signout($request, $response, $args) {
        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('public_home'));
    }
}
