<?php

namespace App\Controllers\Admin;
use App\Models\User;

class AdminController extends Controller
{
    public function index($request, $response, $args)
    {        
        return $this->view->render($response, 'admin/index.twig');       
    }

    public function trystyle($request, $response, $args)
    {        
        return $this->view->render($response, 'admin/trystyle.twig');       
    }
}
