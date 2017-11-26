<?php

namespace App\Controllers;
use App\Models\User;

class AuthController extends Controller
{
    public function login($request, $response, $args)
    {        
        return $this->view->render($response, 'admin/auth/login.twig');       
    }
}