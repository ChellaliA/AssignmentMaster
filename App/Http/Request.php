<?php

namespace App\Http;


class Request
{
    protected $body;
    public $Params;
    protected $server;
    protected $id;


    public function __construct($body, $Params, $server)
    {
        $this->id - null;
        $this->Params = $Params;
        $this->body = $body;
        $this->server = $server;
    }

    public function body()
    {
        return $this->body;
    }

    public function method()
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function path()
    {
        $path = $this->server['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function fullUrl()
    {

        return trim($this->Params['url'], '/') ?? null;
    }

    public function get(string $key)
    {
        return $this->Params[$key] ?? null;
    }

    public function post($key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }


    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id=$id;
    }
    public function is_ajax()
    {
       return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }


}
