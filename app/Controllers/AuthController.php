<?php

namespace App\Controllers;
use App\Models\User;
use Respect\Validation\Validator as v;


class AuthController extends Controller
{
    public function signin($request, $response, $args) {
        if ($this->container->auth->check())
            return $response->withRedirect($this->container->router->pathFor('admin_home'));

        return $this->view->render($response, 'auth/signin.twig');
    }

    public function signinPost($request, $response, $args){            

        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'password' => v::notEmpty()->length(6, null),
        ]);

        if ($validation->failed()) {
            $this->flash->addMessage('danger', 'Le formulaire n\'est pas valide.');
            return $response->withRedirect($this->router->pathFor('auth_signin'));
        }

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
