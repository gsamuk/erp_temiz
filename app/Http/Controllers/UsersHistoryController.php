<?php

namespace App\Http\Controllers;

use App\Models\UsersHistory;
use App\Http\Requests\StoreUsersHistoryRequest;
use App\Http\Requests\UpdateUsersHistoryRequest;

class UsersHistoryController extends Controller
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
     * @param  \App\Http\Requests\StoreUsersHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UsersHistory  $usersHistory
     * @return \Illuminate\Http\Response
     */
    public function show(UsersHistory $usersHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UsersHistory  $usersHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(UsersHistory $usersHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersHistoryRequest  $request
     * @param  \App\Models\UsersHistory  $usersHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersHistoryRequest $request, UsersHistory $usersHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UsersHistory  $usersHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsersHistory $usersHistory)
    {
        //
    }
}
