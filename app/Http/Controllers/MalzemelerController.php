<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MalzemelerController extends Controller
{
    public function index()
    {
        return view('malzemeler.liste');
    }
}
