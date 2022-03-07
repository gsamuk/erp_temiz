<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Logo extends Controller
{
    public function index($table)
    {
        return dd(DB::table($table)->get());
    }
}
