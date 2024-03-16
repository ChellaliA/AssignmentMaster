<?php


namespace App\Controllers;


use App\Http\Request;
use App\Http\Response;
use App\Models\Course;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Submission;
use App\Helpers\ViewManager;
use App\Controllers\Controller;
use App\Helpers\SessionManager;
use App\Exceptions\DatabaseException;

class AssignmentController extends Controller
{



   public function index(Request $request)
   {
      if (SessionManager::get('user_type') === 'Student') {
         return $this->showAssignmentForStudent($request);
      } elseif (SessionManager::get('user_type') === 'Teacher') {
         return $this->showAssignmentForTeacher($request);
      }
   }

   private function showAssignmentForStudent(Request $request) {
      $student=(new Student())->getStudentId(SessionManager::get('user_id'));
      $assignment= (new Assignment())->getAssignmentInfoForStudent($request->id(), $student->student_id);
      return new Response(var_dump($assignment));
   }

   private function showAssignmentForTeacher(Request $request) {
      $assignment= (new Assignment())->getAssignmentInfoForTeacher($request->id());
      $submissions=(new Submission())->getAssignmentSubmissions($request->id());
      return new Response(var_dump($assignment,$submissions));
   }

   public function create(Request $request)
   {
      $data=$request->body();
      $data['course_id'] = $request->id();
      try {
         $Assignment = (new Assignment())->createAssignment($data);
         if ($Assignment) {
            return new Response("Assignment created successfully ");
         }
      } catch (DatabaseException $e) {
         return new Response("Error Creating an Assignment: " . $e->getMessage());
      }
   }

}
