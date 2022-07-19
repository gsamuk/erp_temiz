<?php

namespace App\Http\Controllers;



class Telegram extends Controller
{

    static function send_msg($msg)
    {
        $website = "https://api.telegram.org/bot5291148194:AAFrWViBkJigoqBPvsajyAfM04KX76YjdCg";
        $params = [
            'chat_id' => '-1001606482973',
            'parse_mode' => 'markdown',
            'text' => $msg,
        ];
        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}