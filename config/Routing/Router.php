<?php

namespace config\Routing;

use App\Http\Request;
use config\Routing\Route;
use App\Exceptions\URL_Exception;

class Router {

    public $url;
    public $routes = [];

    public function __construct()
    {   
    }

    public function get(string $path, $action, $middlewares = [])
    {
        $this->routes['GET'][] = new Route($path, $action, $middlewares);
    }

    public function post(string $path, $action, $middlewares = [])
    {
        $this->routes['POST'][] = new Route($path, $action, $middlewares);
    }

    public function run()
    {
        $request = new Request($_POST,$_GET,$_SERVER);

        foreach ($this->routes[$request->method()] as $route) {
            if ($route->matches($request)) {
                if ($route->hasMiddleware()) {
                    $middlewares = $route->getMiddlewares();
                    $handler = function ($request) use ($route) {
                        $response = $route->execute($request);
                        return  $response->send();
                    };
                    foreach ($middlewares as $middleware) {
                        $handler = function ($request) use ($middleware, $handler) {
                            return $middleware->handle($request, $handler);
                        };
                    }
                    return $handler($request);
                } else {
                     $response = $route->execute($request);
                     return  $response->send();
                }
            }
        }

        //return header('404 Not Found ');
        throw URL_Exception::Url404();
    }
}
