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
}
