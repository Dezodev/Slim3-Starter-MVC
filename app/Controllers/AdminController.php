<?php

namespace App\Controllers;
use App\Models\User;

class AdminController extends Controller
{
    public function index($request, $response, $args)
    {        
        return $this->view->render($response, 'admin/index.twig');       
    }
}
