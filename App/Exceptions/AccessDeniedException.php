<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class AccessDeniedException extends Exception {



    public function __construct($message = "", $code = 403, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    
    public static function JobAccessDenied(){
		return new static ("Access Denied: You do not have permission to access this content.");
	}
   

    


}
