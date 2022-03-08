<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Login;


class LoginController extends Controller
{

    public function login()
    {
        return view("auth.login");
    }


    public function login_post(Request $request)
    {

        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ]);
        $user_name = $request->user_name;
        $password = $request->password;
        $rememberme = $request->has('rememberme') ? true : false;


        $user = Login::where('users.user_name', $user_name)
            ->where('users.password', $password)
            ->join('Authorizations', 'users.id', '=', 'authorizations.user_id')
            ->select(
                'users.*',
                'authorizations.purchase_view',
                'authorizations.sale_view',
                'authorizations.purchase_approve',
                'authorizations.sale_approve',
                'authorizations.is_admin'
            )
            ->first();

        if ($user) {

            $request->session()->put('userData', $user);

            if ($rememberme) {
                Cookie::queue(Cookie::make('rememberme', true, 500));
                Cookie::queue(Cookie::make('password', $password, 500));
                Cookie::queue(Cookie::make('user_name', $user_name, 500));
            } else {
                Cookie::queue(Cookie::forget('rememberme'));
                Cookie::queue(Cookie::forget('password'));
                Cookie::queue(Cookie::forget('user_name'));
            }

            if ($user->logo_user && $user->logo_password) {

                $logo = Http::asForm()->post(env('LOGO_API_URL') . '/token', [
                    'username' => $user->logo_user,
                    'password' => $user->logo_password,
                    'firmno' => env('LOGO_DEFAULT_FIRM_NO'),
                    'grant_type' => 'password',

                    'headers' => [
                        'Authorization' => 'Basic ' . env('LOGO_API_KEY'),
                        'Accept' => 'application/json',
                    ]
                ]);

                if ($logo) {

                    if ($logo->status() == 200) {
                        $request->session()->put('LogoLogin', true);
                        $request->session()->put('LogoData', $logo);
                    } elseif ($logo->status() == 400) {
                        $request->session()->put('LogoLogin', false);
                    }
                }
            } else {
                $request->session()->put('LogoLogin', false);
            }

            return redirect()->intended('/')->withSuccess('Signed in');
        } else {
            $request->session()->forget('userData');
            $request->session()->forget('LogoData');
            $request->session()->put('LogoLogin', false);
            return redirect("login")->with('message', 'Hatalı Kullanıcı Adı yada Şifre');
        }
    }


    public function signOut(Request $request)
    {
        $request->Session()->flush();
        return Redirect('login');
    }
}
