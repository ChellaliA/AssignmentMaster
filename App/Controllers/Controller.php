<?php

namespace App\Controllers;

use App\Helpers\SessionManager;

use App\Helpers\ViewManager;

abstract class Controller

{

    protected $view;

    public function __construct()
    {
        SessionManager::start();
        $view = new ViewManager();
    }
    
}
