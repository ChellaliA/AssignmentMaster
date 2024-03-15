<?php

namespace App\Controllers;

use App\Helpers\SessionManager;


abstract class Controller

{


    public function __construct()
    {
        SessionManager::start();
    }
    
}
