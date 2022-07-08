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

    public function upload()
    {
        return view('image_upload');
    }
}