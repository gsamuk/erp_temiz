<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
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


        $user = Login::where('users.user_name', $user_name)
            ->where('users.password', $password)
            ->join('Authorizations', 'users.id', '=', 'authorizations.user_id')
            ->select('users.*', 'authorizations.purchase_view', 'authorizations.sale_view', 'authorizations.purchase_approve', 'authorizations.sale_approve')
            ->first();

        if ($user) {


            $request->session()->put('userData', $user);

            $logo = Http::asForm()->post('http://65.21.157.111:32001/api/v1/token', [
                'username' => 'LOGO',
                'password' => 'dekatek',
                'firmno' => 1,
                'grant_type' => 'password',

                'headers' => [
                    'Authorization' => 'Basic k8TM58bDD6HEgzEuI9WOxf/gZai+NLuWMiobQp8/YwQ=',
                    'Accept' => 'application/json',
                ]
            ]);

            if ($logo) {
                if ($logo->status() == 200) {
                    $request->session()->put('LogoData', (object) $logo->json());
                } elseif ($logo->status() == 400) {
                    $request->session()->put('LogoData', $logo->status());
                }
            }
            return redirect()->intended('/')->withSuccess('Signed in');
        } else {
            $request->session()->forget('userData');
            $request->session()->forget('LogoData');
            return redirect("login")->with('message', 'Hatalı Kullanıcı Adı yada Şifre');
        }
    }


    public function signOut(Request $request)
    {
        $request->Session()->flush();
        return Redirect('login');
    }
}
