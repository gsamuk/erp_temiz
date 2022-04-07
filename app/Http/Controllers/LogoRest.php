<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Exception;

class LogoRest extends Controller
{
    static function rest_url($p = null)
    {
        if ($p) {
            return 'http://65.21.157.111:32001/api/v1/' . $p;
        } else {
            return 'http://65.21.157.111:32001/api/v1';
        }
    }

    static function SiparisOlustur($data, $sid)
    {
        try {
            if ($sid > 0) {
                $msg = "Sipariş Kaydı Düzenlendi";
                $url = Self::rest_url('purchaseOrders/' . $sid);
                $response = Http::withToken(Cookie::get("logo_access_token"))->put($url, $data);
            } else {
                $msg = "Yeni Sipariş Oluşturuldu";
                $url = Self::rest_url('purchaseOrders');
                $response = Http::withToken(Cookie::get("logo_access_token"))->post($url, $data);
            }


            if ($response->status() == 200 && $response->successful() == true) {
                TransactionController::add($url, $data, $response->body());
                return session()->flash('success', $msg . ' ID #' . $response->json("INTERNAL_REFERENCE"));
            } else {
                TransactionController::add($url, $data, $response->body());
                return session()->flash('error', serialize($response->body()));
            }
        } catch (Exception $e) {
            TransactionController::add($url, $data, $e->getMessage());
            return session()->flash('error', $e->getMessage());
        }
    }


    static function SiparisSil($data)
    {
        $id = $data['id'];
        try {
            $url = Self::rest_url('purchaseOrders/' . $id);
            $response = Http::withToken(Cookie::get("logo_access_token"))->delete($url);
            if ($response->status() == 200 && $response->successful() == true) {
                TransactionController::add($url, $data, $response->body());
                return session()->flash('success', 'Başarılı Sipariş Silindi' . $response->json("INTERNAL_REFERENCE"));
            } else {
                TransactionController::add($url, $data, $response->body());
                return session()->flash('error', serialize($response->body()));
            }
        } catch (Exception $e) {
            TransactionController::add($url, $data, $e->getMessage());
            return session()->flash('error', $e->getMessage());
        }
    }



    static function SiparisStatus($data)
    {
        $id = $data['id'];
        $po_status = $data['po_status'];
        $header = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'ORDER_STATUS' => $po_status
        ];

        try {
            $url = Self::rest_url('purchaseOrders/' . $id);
            $response = Http::withToken(Cookie::get("logo_access_token"))->put($url, $header);
            if ($response->status() == 200 && $response->successful() == true) {
                TransactionController::add($url, $data, $response->body());
                return session()->flash('success', 'Başarılı Sipariş Onaylandı' . $response->json("INTERNAL_REFERENCE"));
            } else {
                TransactionController::add($url, $data, $response->body());
                return session()->flash('error', serialize($response->body()));
            }
        } catch (Exception $e) {
            TransactionController::add($url, $data, $e->getMessage());
            return session()->flash('error', $e->getMessage());
        }
    }
}
