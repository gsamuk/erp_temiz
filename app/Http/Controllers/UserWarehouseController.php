<?php

namespace App\Http\Controllers;

use App\Models\UserWarehouse;
use App\Http\Requests\StoreUserWarehouseRequest;
use App\Http\Requests\UpdateUserWarehouseRequest;

class UserWarehouseController extends Controller
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
     * @param  \App\Http\Requests\StoreUserWarehouseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserWarehouseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserWarehouse  $userWarehouse
     * @return \Illuminate\Http\Response
     */
    public function show(UserWarehouse $userWarehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserWarehouse  $userWarehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(UserWarehouse $userWarehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserWarehouseRequest  $request
     * @param  \App\Models\UserWarehouse  $userWarehouse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserWarehouseRequest $request, UserWarehouse $userWarehouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserWarehouse  $userWarehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserWarehouse $userWarehouse)
    {
        //
    }
}
