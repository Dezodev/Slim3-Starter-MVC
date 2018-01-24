<?php

namespace App\Middleware;

class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if ($this->container->auth->check()) {
            $this->container->flash->addMessage('warning', 'Vous ne devez pas être connecté pour accéder à cette page.');

            return $response->withRedirect($this->container->router->pathFor('public_home'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
