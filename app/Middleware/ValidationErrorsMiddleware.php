<?php

namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (isset($_SESSION['validatorError'])) {
            $this->container->view->getEnvironment()->addGlobal('validatorError', $_SESSION['validatorError']);
            unset($_SESSION['validatorError']);
        }

        $response = $next($request, $response);
        return $response;
    }
}
