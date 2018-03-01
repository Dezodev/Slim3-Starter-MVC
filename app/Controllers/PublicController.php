<?php

namespace App\Controllers;
use App\Models\User;

class PublicController extends Controller
{
    public function index($request, $response, $args)
    {
        return $this->view->render($response, 'public/index.twig');
    }

    public function maintenance($request, $response, $args) {
        return $this->view->render($response, 'public/maintenance.twig');
    }
}
