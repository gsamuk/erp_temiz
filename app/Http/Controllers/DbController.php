<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DbController extends Controller
{

    static function getSiparis($id)
    {
        return DB::table('lv_purchase_order')->where('logicalref', '=', $id)->first();
    }

    static function getSiparisDetay($id)
    {
        return DB::table('lv_purchase_order_detail')->where('po_ficheref', '=', $id)->get();
    }


    static function getTalep($id)
    {
        return DB::table('lv_demand_001')->where('logicalref', '=', $id)->first();
    }


    static function getTalepDetay($id)
    {
        return DB::table('lv_demand_detail_001')->where('fiche_no', '=', $id)->get();
    }
}
