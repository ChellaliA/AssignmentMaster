<?php

namespace App\Exceptions;

namespace App\Exceptions;

use Exception;
use Throwable;

class URL_Exception extends Exception {

    public function __construct($message = "", $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function Url404()
    {
        http_response_code(404);
        include VIEWS . 'errors/404.php';
        return new static ("Page not Found");
    }

    }
    


