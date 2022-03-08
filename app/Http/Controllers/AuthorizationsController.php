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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAuthorizationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthorizationsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Authorizations  $authorizations
     * @return \Illuminate\Http\Response
     */
    public function show(Authorizations $authorizations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Authorizations  $authorizations
     * @return \Illuminate\Http\Response
     */
    public function edit(Authorizations $authorizations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAuthorizationsRequest  $request
     * @param  \App\Models\Authorizations  $authorizations
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAuthorizationsRequest $request, Authorizations $authorizations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Authorizations  $authorizations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authorizations $authorizations)
    {
        //
    }
}
