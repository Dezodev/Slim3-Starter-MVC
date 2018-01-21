<?php

namespace App\Controllers;
use App\Models\User;

class HomeController extends Controller
{
    public function index($request, $response, $args)
    {
        $this->flash->addMessage('info', '<strong>Erreur :</strong> vous n\'avez pas pu être connecté.');

        return $this->view->render($response, 'home/index.twig');
    }
}
