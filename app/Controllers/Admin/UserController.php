<?php

namespace App\Controllers\Admin;
use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class UserController extends Controller {
    public function index($request, $response, $args) {
        $users = User::all();

        return $this->view->render($response, 'admin/user/index.twig', ['users' => $users]);
    }

    public function new($request, $response, $args) {
        return $this->view->render($response, 'admin/user/new.twig');
    }

    public function create($request, $response, $args) {
        $validation = $this->validator->validate($request, [
            'username' => v::notEmpty()->alnum()->NoWhitespace()->usernameAvailable(),
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'password' => v::notEmpty()->length(6, null),
        ]);

        if ($validation->failed()) {
            $this->flash->addMessage('danger', 'Le formulaire n\'est pas valide.');
            return $response->withRedirect($this->router->pathFor('admin_user_new'));
        }

        $user = User::create([
            'username' => $request->getParam('username'),
            'email' => $request->getParam('email'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        ]);

        $this->flash->addMessage('success', 'L\'utilisateur a bien été créé.');
        return $response->withRedirect($this->router->pathFor('admin_user_list'));
    }
    
    
    public function show($request, $response, $args) {
        $user = User::find($args['id']);
        
        return $this->view->render($response, 'admin/user/show.twig', ['user' => $user]);
    }
    
    public function edit($request, $response, $args) {
        $user = User::find($args['id']);
        
        return $this->view->render($response, 'admin/user/edit.twig', ['user' => $user]);
    }
    
    public function update($request, $response, $args) {
        $user = User::find($args['id']);

        // Check if this field is same in database
        $form_username = ($request->getParam('username') !=  $user->username)? $request->getParam('username') : null;
        $form_email = ($request->getParam('email') !=  $user->email)? $request->getParam('email') : null;

        // Create validation rules
        $arrValidation = [];

        if (!empty($form_username)) $arrValidation['username'] = v::alnum()->NoWhitespace()->usernameAvailable();
        if (!empty($form_email)) $arrValidation['email'] = v::noWhitespace()->email()->emailAvailable();

        $arrValidation['password'] = v::optional(v::length(6, null));
        $arrValidation['password_confirm'] = v::optional(v::length(6, null));

        // Call validation function
        $validation = $this->validator->validate($request, $arrValidation);

        if ($validation->failed()) {
            $this->flash->addMessage('danger', 'Le formulaire n\'est pas valide.');
            return $response->withRedirect($this->router->pathFor('admin_user_edit', ["id" => $user->id]));
        }
        
        // Save fields
        if(!empty($form_username)) $user->username = $form_username;
        if(!empty($form_email)) $user->email = $form_email;
        
        // Checks password
        $passw_error = false;
        if (!empty($request->getParam('password')) && !empty($request->getParam('password_confirm'))) {
            
            if ($request->getParam('password') == $request->getParam('password_confirm')) {
                $user->password = password_hash($request->getParam('password'), PASSWORD_DEFAULT);
            } else {
                $passw_error = true;
                $this->flash->addMessage('danger', 'Les deux champs de mot de passe ne sont pas similaires.');
            }
            
        } elseif (!empty($request->getParam('password')) || !empty($request->getParam('password_confirm'))) {
            $passw_error = true;
            $this->flash->addMessage('danger', 'Les deux champs de mot de passe ne sont pas remplis.');
        }

        if(!$passw_error) {
            $user->save();
            $this->flash->addMessage('success', 'L\'utilisateur a bien été modifié.');
            
            return $response->withRedirect($this->router->pathFor('admin_user_list'));
        } else {
            return $response->withRedirect($this->router->pathFor('admin_user_edit', ["id" => $user->id]));
        }
    }

    public function delete($request, $response, $args) {
        User::destroy($args['id']);

        $this->flash->addMessage('success', 'L\'utilisateur a bien été supprimé.');
        return $response->withRedirect($this->router->pathFor('admin_user_list'));
    }
}
