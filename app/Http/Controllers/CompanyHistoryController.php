<?php

namespace App\Http\Controllers;

use App\Models\CompanyHistory;
use App\Http\Requests\StoreCompanyHistoryRequest;
use App\Http\Requests\UpdateCompanyHistoryRequest;

class CompanyHistoryController extends Controller
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
     * @param  \App\Http\Requests\StoreCompanyHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyHistory  $companyHistory
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyHistory $companyHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyHistory  $companyHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyHistory $companyHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyHistoryRequest  $request
     * @param  \App\Models\CompanyHistory  $companyHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyHistoryRequest $request, CompanyHistory $companyHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyHistory  $companyHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyHistory $companyHistory)
    {
        //
    }
}
