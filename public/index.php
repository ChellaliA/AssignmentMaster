<?php

use config\Routing\Router;
use App\Exceptions\URL_Exception;


require ('./../vendor/autoload.php');
require_once __DIR__ . '/../config/config.php';




$router = new Router();

//test 
$router->get('/test', 'App\Controllers\TestController@index');


try {

    $router->run();
    
} catch (URL_Exception $e) {
    return $e->getMessage();
}
