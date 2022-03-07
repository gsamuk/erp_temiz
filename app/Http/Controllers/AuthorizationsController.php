<?php

namespace App\Http\Controllers;

use App\Models\Authorizations;
use App\Http\Requests\StoreAuthorizationsRequest;
use App\Http\Requests\UpdateAuthorizationsRequest;

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
