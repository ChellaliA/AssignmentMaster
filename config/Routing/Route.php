<?php

namespace config\Routing;

use App\Http\Request;


class Route
{

    public $path;
    public $action;
    public $matches;
    public $middlewares = [];

    public function __construct($path, $action, $middlewares = [])
    {
        $this->path = trim($path, '/');
        $this->action = $action;
        $this->middlewares = $middlewares;
    }

    public function matches(Request $request)
    {

        $url=$request->fullUrl();
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";

        if (preg_match($pathToMatch, $url, $matches)) {
            $this->matches = $matches;

            $id = $this->matches[1] ?? null;
            if($id){
              $request->setId($this->matches[1]);
            }
           
            return true;
        } else {
            return false;
        }
    }

    public function execute(Request $request)
    {
        if (is_callable($this->action)) {
            return call_user_func_array($this->action, array_merge([$request], $this->matches));
        } else {
            $params = explode('@', $this->action);
            $controller = new $params[0]();
            $method = $params[1];

            return $controller->$method($request);
           
        }
    }

    public function hasMiddleware(): bool
    {
        return !empty($this->middlewares);
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
