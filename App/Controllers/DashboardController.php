<?php


namespace App\Controllers;

use App\Http\Response;
use App\Controllers\Controller;
use App\Helpers\SessionManager;

class DashboardController extends Controller
{

   public function index()
   {
    if (SessionManager::get('user_type') === 'Student') {
        $studentController = new StudentController();
        return $studentController->showStudentDashboard();
    } elseif (SessionManager::get('user_type') === 'Teacher') {
        $teacherController = new TeacherController();
        return $teacherController->showTeacherDashboard();
    }
   }

}
