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
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'email:rfc,dns',

        ]);

        Users::Where("id", $request->input("user_id"))
            ->update([
                'name' => $request->input("name"),
                'surname' => $request->input("surname"),
                'email' => $request->input("email"),
                'is_active' => $request->is_active ? 1 : 0,
            ]);
        return redirect("user/" . $request->input("user_id"))->with('message', 'Güncelleme Başarılı');
    }



    public function user_list()
    {
        return view('user.list');
    }
}
