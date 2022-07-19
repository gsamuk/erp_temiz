<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use App\Models\Users;

class Erp
{
    public static function izin($name)
    {
        if (Session::get('izinler')->where('name', $name)->count() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function user_id()
    {
        return Session::get('userData')->id;
    }

    public static function user($id)
    {
        return Users::find($id);
    }


    public static function nmf($n, $s = 0)
    {
        return number_format($n, $s, ',', '.');
    }
}