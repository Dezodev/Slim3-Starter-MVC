<?php

namespace App\Middleware;
use App\Models\Setting;

class MaintenanceModeMiddleware extends Middleware
{
    public function __invoke($request, $response, $next) {
        $route = $request->getAttribute('route');

        // return NotFound for non existent route
        if (empty($route)) {
            throw new NotFoundException($request, $response);
        }

        $rName = $route->getName();
        $maintMode = Setting::where('slug', 'maintenance_mode')->first();

        // $this->container['logger']->info('route name =>', [ 'routename' => $rName ]);

        if ($rName != 'public_maintenance' && $maintMode->value == '1') {
            $response = $response->withRedirect($this->container['router']->pathFor('public_maintenance'));
        } else {
            $response = $next($request, $response);
        }

        return $response;
    }
}
