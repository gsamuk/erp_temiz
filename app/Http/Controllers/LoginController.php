<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{

    public function login()
    {
        return view("auth.login");
    }

    public function signOut(Request $request)
    {
        $request->Session()->flush();
        return Redirect('login');
    }
}
