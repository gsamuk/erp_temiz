<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function profil()
    {
        $id = 1;
        $user = User::Where("id", $id)->first();
        return view('user_profil', $user);
    }


    public function profil_post(Request $request)
    {

        $request->validate([
            'ad' => 'required',
            'soyad' => 'required',
            'email' => 'email:rfc,dns',
        ]);

        User::Where("id", $request->input("user_id"))
            ->update([
                'name' => $request->input("ad"),
                'surname' => $request->input("soyad"),
                'email' => $request->input("email")
            ]);
        return redirect("profil")->with('message', 'Güncelleme Başarılı');
    }
}
