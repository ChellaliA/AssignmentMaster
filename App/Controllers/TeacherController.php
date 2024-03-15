<?php


namespace App\Controllers;



use App\Http\Response;
use App\Models\Teacher;
use App\Controllers\Controller;
use App\Helpers\SessionManager;
use App\Models\Course;

class TeacherController extends Controller
{

   public function showTeacherDashboard()
   {
      $teacher= (new Teacher())->getTeacherById(SessionManager::get('user_id'));
      $courses = (new Course())->getTeacherCreatedCourses($teacher->teacher_id);
      return  new Response(var_dump($teacher,$courses));
   }
}
