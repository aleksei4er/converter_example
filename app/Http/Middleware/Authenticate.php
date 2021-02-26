<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Api\ExampleController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Routing\RouteAction;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (AuthenticationException $e) {

            /** @var \Illuminate\Routing\Route $route */
            $route = $request->route();
      
            $routeAction = array_merge(
                $route->getAction(),
                RouteAction::parse($route->uri(), [ExampleController::class, 'badAuthentication'])
            );
        
            $route->setAction($routeAction);
        }
        
        return $next($request);
    }
}
