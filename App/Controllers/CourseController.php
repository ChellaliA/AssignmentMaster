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
use App\Models\Enrollment;
use App\Models\Student;

class CourseController extends Controller
{

   public function index(Request $request)
   {
      if (SessionManager::get('user_type') === 'Student') {
         return $this->showCourseForStudent($request);
      } elseif (SessionManager::get('user_type') === 'Teacher') {
         return $this->showCourseForTeacher($request);
      }
   }

   private function showCourseForStudent(Request $request) {
      $course = (new Course())->getCourseInfoForStudent($request->id());
      $student=(new Student())->getStudentId(SessionManager::get('user_id'));
      $assignments= (new Assignment())->getAssignmentsForStudent($course->course_id,$student->student_id);
      return new Response(var_dump($course,$assignments));
   }

   private function showCourseForTeacher(Request $request) {
      $course = (new Course())->getCourseInfoForTeacher($request->id());
      $assignments= (new Assignment())->getAssignmentsForTeacher($course->course_id);
      $enrolledStudents = (new Enrollment())->getEnrolledStudents($request->id());
      $PendingStudents = (new Enrollment())->getPendingStudents($request->id());
      return new Response(var_dump($course, $assignments, $enrolledStudents, $PendingStudents));
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
