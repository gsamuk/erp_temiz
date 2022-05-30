<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function root()
    {
        return view('index');
    }

    public function malzeme_detay($sku)
    {
        return view('mobile_index', ['sku' => $sku]);
    }

    public function mobile()
    {
        return view('mobile_index');
    }

    public function talep_olustur()
    {
        return view('mobile_talep_olustur');
    }

    public function talepler()
    {
        return view('mobile_talepler');
    }
}
