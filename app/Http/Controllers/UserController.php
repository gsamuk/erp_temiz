<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;


class UserController extends Controller
{

    public function user($id)
    {
        $user = Users::where('users.id', $id)
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

        return view('user.profil', $user);
    }

    public function profil_post(Request $request)
    {

        $request->validate(
            [
                'name' => 'required',
                'surname' => 'required',
                'user_name' => 'required|unique:users,user_name,' . $request->input("user_id"),
                'email' => 'required|email|unique:users,email,' . $request->input("user_id"),
            ],
            [
                'user_name.unique' => $request->input("user_name") . ' > Bu Kullanıcı Adı Kullanılıyor',
                'email.unique' => $request->input("email") . ' > Bu Email Adresi Kullanılıyor'
            ]
        );

        Users::Where("id", $request->input("user_id"))
            ->update([
                'name' => $request->input("name"),
                'surname' => $request->input("surname"),
                'user_name' => $request->input("user_name"),
                'email' => $request->input("email"),
                'logo_user' => $request->input("logo_user"),
                'logo_password' => $request->input("logo_password"),
                'is_active' => $request->is_active ? 1 : 0,
            ]);
        return redirect("user/" . $request->input("user_id"))->with('message', 'Güncelleme Başarılı');
    }



    public function password_change(Request $request)
    {
        $request->validate(
            [
                'password'         => 'required',
                'password_confirm' => 'required|same:password'
            ],
            [
                'password.required' =>   'Şifre Giriniz',
                'password_confirm.required' => 'Şifreyi tekrar giriniz',
                'password_confirm.same' => 'Şifreler Aynı Olmalı'
            ]
        );

        Users::Where("id", $request->input("user_id"))
            ->update([
                'password' => $request->input("password"),
            ]);
        return redirect("user/" . $request->input("user_id"))->with('message', 'Güncelleme Başarılı');
    }



    public function user_list() // liveWare ile yapıldı
    {
        return view('user.list');
    }

    public function firma_sec() // liveWare ile yapıldı
    {
        return view('user.firma-sec');
    }
}
