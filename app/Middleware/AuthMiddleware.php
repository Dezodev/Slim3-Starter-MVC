<?php

namespace App\Middleware;

class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (!$this->container->auth->check()) {
            $this->container->flash->addMessage('warning', 'Vous devez être connecté pour accéder à cette page.');

            return $response->withRedirect($this->container->router->pathFor('auth_signin'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
