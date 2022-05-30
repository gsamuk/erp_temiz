<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MalzemelerController extends Controller
{
    public function index()
    {
        return view('malzemeler.liste');
    }


    public function taleplerim()
    {
        return view('malzemeler.taleplerim');
    }

    public function talep_listesi()
    {
        return view('malzemeler.talep_listesi');
    }


    public function talep_olustur()
    {
        return view('malzemeler.talep_olustur', ['id' => 0]);
    }


    public function talep_duzenle($id)
    {
        return view('malzemeler.talep_olustur', ['id' => $id]);
    }


    public function fotograf()
    {
        return view('malzemeler.fotograf');
    }
}
