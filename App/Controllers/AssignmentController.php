<?php


namespace App\Controllers;


use App\Http\Request;
use App\Http\Response;
use App\Models\Course;
use App\Helpers\ViewManager;
use App\Controllers\Controller;
use App\Helpers\SessionManager;
use App\Exceptions\DatabaseException;
use App\Models\Assignment;

class AssignmentController extends Controller
{

   public function index()
   {
      $body = ViewManager::renderView('test');
      //$body = ViewManager::renderView('web.users', compact('object1', 'object2'));
      return  new Response($body);
   }


   public function create(Request $request)
   {
      $data=$request->data();
      $data['course_id'] = $request->id();
      try {
         $Assignment = (new Assignment())->create($data);
         if ($Assignment) {
            return new Response("Assignment created successfully ");
         }
      } catch (DatabaseException $e) {
         return new Response("Error Creating an Assignment: " . $e->getMessage());
      }
   }
   
   public function redirect(Request $request)
   {
      var_dump($request->data());
      return (new Response())->redirect(BASE_URL . '/test');
   }

}
