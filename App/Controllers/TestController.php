<?php


namespace App\Controllers;


use App\Http\Request;
use App\Http\Response;
use App\Helpers\ViewManager;
use App\Controllers\Controller;


class TestController extends Controller
{

   public function index()
   {
      $body = ViewManager::renderView('test');
      //$body = ViewManager::renderView('web.users', compact('object1', 'object2'));
      return  new Response($body);
   }


   public function redirect(Request $request)
   {
      var_dump($request->body());
      return (new Response())->redirect(BASE_URL . '/test');
   }

}
