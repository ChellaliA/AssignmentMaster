<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DatabaseException extends \PDOException {

    private $query;

    public function __construct($message = "", $code = 0, $query='', ?Throwable $previous = null)
    {
        $this->query = $query;
        parent::__construct($message, $code, $previous);
    }

    public function getQuery()
    {
        return $this->query;
    }

    public static function error($message = "", $query = "")
    {
        return new static($message, 0, $query);
    }

}









