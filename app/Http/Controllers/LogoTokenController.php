<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Session;
use App\Models\Users;
use App\Models\LogoUserTokens;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class LogoTokenController extends Controller
{

    static function getToken($firma_id)
    {
        $user_id = Session::get('userData')->id;
        $user = Users::find($user_id);
        if ($user->logo_user && $user->logo_password) {

            $logo = Http::asForm()->post('http://65.21.157.111:32001/api/v1/token', [
                'username' => $user->logo_user,
                'password' => $user->logo_password,
                'firmno' => $firma_id,
                'grant_type' => 'password',
                'headers' => [
                    'Authorization' => 'Basic k8TM58bDD6HEgzEuI9WOxf/gZai+NLuWMiobQp8/YwQ=',
                    'Accept' => 'application/json',
                ]
            ]);

            if ($logo) {
                if ($logo->status() == 200) {
                    // Yoksa Ekler varsa update eder        
                    LogoUserTokens::updateOrCreate(
                        [
                            'user_id' => $user_id,
                            'firma_id' => $firma_id
                        ],
                        [
                            'access_token' => $logo->json("access_token"),
                            'refresh_token' => $logo->json("refresh_token"),
                            'expires_in' => $logo->json("expires_in")
                        ]
                    );

                    Cookie::queue(Cookie::make('logo_access_token', $logo->json("access_token"), 500000));
                    Cookie::queue(Cookie::make('logo_refresh_token', $logo->json("refresh_token"), 500000));
                    Cookie::queue(Cookie::make('logo_firma_id', $firma_id, 500000));
                    return true;
                } else {
                    return $logo->status();
                }
            }
        }
    }
}
