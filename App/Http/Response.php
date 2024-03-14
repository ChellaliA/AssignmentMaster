<?php

namespace App\Http;

class Response
{
    private $body;
    private $statusCode;
    private $headers;
    

    public function __construct($body = '', $statusCode = 200,$headers =[])
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->headers = [];
    }

    public function withHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function redirect(string $url): void
    {
        header("Location: $url");
    }

    public function render(string $view, array $data = []): void
    {
        extract($data);
        ob_start();
        include_once(__DIR__ . "/../views/$view.php");
        $this->body = ob_get_clean();
        $this->send();
    }

    public function send(): void
    {
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        http_response_code($this->statusCode);
        echo $this->body;
    }

    public function setbody($body){
        $this->body=$body;
    }

    public function setstatusCode($statusCode){
        $this->statusCode=$statusCode;
    }
}




