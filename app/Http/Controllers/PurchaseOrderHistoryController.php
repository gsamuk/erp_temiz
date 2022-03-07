<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderHistory;
use App\Http\Requests\StorePurchaseOrderHistoryRequest;
use App\Http\Requests\UpdatePurchaseOrderHistoryRequest;

class PurchaseOrderHistoryController extends Controller
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
     * @param  \App\Http\Requests\StorePurchaseOrderHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseOrderHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrderHistory  $purchaseOrderHistory
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrderHistory $purchaseOrderHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrderHistory  $purchaseOrderHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrderHistory $purchaseOrderHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseOrderHistoryRequest  $request
     * @param  \App\Models\PurchaseOrderHistory  $purchaseOrderHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseOrderHistoryRequest $request, PurchaseOrderHistory $purchaseOrderHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrderHistory  $purchaseOrderHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrderHistory $purchaseOrderHistory)
    {
        //
    }
}
