<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SatinAlmaController extends Controller
{
    public function siparis()
    {
        return view('satinalma.siparis');
    }

    public function siparis_olustur()
    {
        return view('satinalma.siparis_olustur', ['id' => 0]);
    }

    public function siparis_duzenle($id = null)
    {
        return view('satinalma.siparis_olustur', ['id' => $id]);
    }

    public function irsaliye()
    {
        return view('satinalma.irsaliye');
    }

    public function fatura()
    {
        return view('satinalma.fatura');
    }

    public function onay()
    {
        return view('satinalma.onay');
    }
}
