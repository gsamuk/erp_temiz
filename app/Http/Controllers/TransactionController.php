<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\LogoTransaction;

class TransactionController extends Controller
{
    static function add($url, $req, $res)
    {
        $lt = new LogoTransaction();
        $lt->post_url = $url;
        $lt->request = serialize($req);
        $lt->response = serialize($res);
        $lt->sent_time = date('Y-m-d H:i:s');
        $lt->save();
    }
}
