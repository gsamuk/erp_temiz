<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MalzemelerController extends Controller
{
    public function index()
    {
        return view('malzemeler.liste');
    }


    public function talep_olustur()
    {
        return view('malzemeler.talep_olustur');
    }
}
