<?php

namespace App\Http\Controllers;

use App\Models\Authorizations;
use App\Http\Requests\StoreAuthorizationsRequest;
use App\Http\Requests\UpdateAuthorizationsRequest;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function set_authorizations(Request $request)
    {
        Authorizations::where('user_id', $request->user_id)
            ->update([
                'purchase_view' => $request->purchase_view ? 1 : 0,
                'sale_view' => $request->sale_view ? 1 : 0,
                'purchase_approve' => $request->purchase_approve ? 1 : 0,
                'sale_approve' => $request->sale_approve ? 1 : 0,
                'is_admin' => $request->is_admin ? 1 : 0,
            ]);
        return redirect()->back()->with(['success' => 'Yetkiler Güncellendi!']);
    }
}
