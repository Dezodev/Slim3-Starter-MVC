<?php

namespace App\Middleware;

class OldInputsMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if(!isset($_SESSION['oldInputs'])) $_SESSION['oldInputs'] = null;
                
        $this->container->view->getEnvironment()->addGlobal('oldInputs', $_SESSION['oldInputs']);
        $_SESSION['oldInputs'] = $request->getParams();

        $response = $next($request, $response);
        return $response;
    }
}
