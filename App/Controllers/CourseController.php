<?php


namespace App\Controllers;


use App\Http\Request;
use App\Http\Response;
use App\Models\Course;
use App\Helpers\ViewManager;
use App\Controllers\Controller;
use App\Helpers\SessionManager;
use App\Exceptions\DatabaseException;

class CourseController extends Controller
{

   public function index()
   {
      if (SessionManager::get('user_type') === 'Student') {
         return $this->showCourseForStudent();
      } elseif (SessionManager::get('user_type') === 'Teacher') {
         return $this->showCourseForTeacher();
      }
   }

   private function showCourseForStudent() {
      
   }

   private function showCourseForTeacher() {
      
   }

   public function create(Request $request)
   {
      $data=$request->body();
      $body['teacher_id'] = SessionManager::get('user_id');
      try {
         $course = (new Course())->createCourse($body);
         if ($course) {
            return new Response("course created successfully ");
         }
      } catch (DatabaseException $e) {
         return new Response("Error Creating a course: " . $e->getMessage());
      }

   }

}
