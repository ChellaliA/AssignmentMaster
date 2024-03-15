<?php

namespace App\Controllers;


use App\Models\User;
use App\Http\Request;
use App\Http\Response;
use App\Helpers\ViewManager;
use App\Controllers\Controller;
use App\Helpers\SessionManager;
use App\Helpers\Validation\Validator;



class AuthController extends Controller
{

    public function login()
    {
        $body = ViewManager::renderView('auth.logIn');
        return  new Response($body);
    }

    public function loginPost(Request $request)
    {
        $errors = (new Validator())->LoginValidate($request->body());
        if (count($errors) > 0) {
            return new Response("inputs error: ", $errors);
        } else {
            $user = (new User())->getUserByUsername($request->body()['username']);
            if ($user) {
                if (password_verify($request->body()['password'], $user->password)) {
                    SessionManager::set('user_id', $user->user_id);
                    SessionManager::set('user_type', $user->user_type);
                    SessionManager::setAuthenticated(true);
                    if (SessionManager::get('user_type') == 'Student')
                        return (new Response())->redirect(STUDENT_DASHBOARD_URL);
                    if (SessionManager::get('user_type') == 'Teacher')
                        return new Response("log in successfully");
                    //return (new Response())->redirect(TEACHER_COURSE_URL);
                } else {
                    return new Response("log in failed : wrong password");
                }
            }
            return new Response("log in failed : wrong username");
            //return (new Response())->redirect(LOGIN_URL . '?success=false');
        }
    }


    public function logout()
    {
        // session_destroy();
        SessionManager::destroy();
        return (new Response())->redirect('/AssignmentMaster/test');
    }
}
