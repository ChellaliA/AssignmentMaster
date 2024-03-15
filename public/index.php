<?php

use config\Routing\Router;
use App\Exceptions\URL_Exception;


require ('./../vendor/autoload.php');
require_once __DIR__ . '/../config/config.php';


$router = new Router();

// test 
$router->get('/test', 'App\Controllers\TestController@index');

// Auth
$router->get('/login','App\Controllers\AuthController@login');
$router->post('/login','App\Controllers\AuthController@loginPost');
$router->post('/logout','App\Controllers\AuthController@logout');

// User Dashboard
$router->get('/dashboard','App\Controllers\DashboardController@index');

//Teacher
$router->post('/courses/create','App\Controllers\CourseController@create');
$router->post('/courses/:id','App\Controllers\CourseController@index');
$router->post('/courses/:id/assignments/create','App\Controllers\AssignmentController@create');

try {

    $router->run();
    
} catch (URL_Exception $e) {
    return $e->getMessage();
}
