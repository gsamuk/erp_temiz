<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

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
}
