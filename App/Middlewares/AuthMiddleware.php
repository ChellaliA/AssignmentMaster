<?php

namespace App\Middlewares;

use App\Controllers\AuthController;
use Closure;
use App\Http\Request;
use App\Helpers\SessionManager;


class AuthMiddleware extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        SessionManager::start();
        //echo "AuthMiddleware is runing.....";
        if (SessionManager::isAuthenticated()) {
            return $next($request);
        } else {
            $response = (new AuthController())->login();
            $response->setstatusCode(401);
            return  $response->send();
        }
    }
}
