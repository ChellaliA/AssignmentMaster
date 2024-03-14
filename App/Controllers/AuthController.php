<?php

namespace App\Controllers;


use App\Http\Request;
use App\Http\Response;
use App\Helpers\ViewManager;
use App\Controllers\Controller;
use App\Helpers\SessionManager;


class AuthController extends Controller
{

    public function login()
    {
        $body = (new ViewManager())->renderView('auth.logIn');
        return  new Response($body);
    }

    public function loginPost(Request $request)
    {
    
    }

    public function logout()
    {
        // session_destroy();
        SessionManager::destroy();
        return (new Response())->redirect('/AssignmentMaster');
    }

}
