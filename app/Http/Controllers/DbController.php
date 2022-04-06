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
}
