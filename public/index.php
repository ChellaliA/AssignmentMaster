<?php

use config\Routing\Router;
use App\Exceptions\URL_Exception;


require ('./../vendor/autoload.php');
require_once __DIR__ . '/../config/config.php';


$router = new Router();

// test 
$router->get('/test', 'App\Controllers\TestController@index');

// auth
$router->get('/login','App\Controllers\AuthController@login');
$router->post('/login','App\Controllers\AuthController@loginPost');
$router->post('/logout','App\Controllers\AuthController@logout');

// dashboard
$router->get('/dashboard','App\Controllers\DashboardController@index');



// course
$router->get('/courses/:id','App\Controllers\CourseController@index'); // view course
$router->post('/courses/create','App\Controllers\CourseController@create'); // create course

// assignment
$router->get('/assignments/:id','App\Controllers\AssignmentController@index'); // view assignment
$router->post('/courses/:id/assignments/create','App\Controllers\AssignmentController@create'); // create assignment

try {

    $router->run();
    
} catch (URL_Exception $e) {
    return $e->getMessage();
}
