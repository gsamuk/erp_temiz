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
        Cookie::queue(Cookie::forget('logo_access_token'));
        Cookie::queue(Cookie::forget('logo_refresh_token'));
        Cookie::queue(Cookie::forget('logo_firma_id'));
        Cookie::queue(Cookie::forget('secili_firma'));
        Cookie::queue(Cookie::forget('secili_firma_adi'));
        return Redirect('login');
    }
}
