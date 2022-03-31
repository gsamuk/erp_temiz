<?php

namespace App\Http\Livewire\Satinalma;

use Livewire\Component;
use App\Models\LogoDb;
use App\Models\LogoUnits;
use App\Models\LogoWarehouses;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class Siparis extends Component
{

    public $tip, $kod, $aciklama, $miktar, $birim, $birim_fiyat, $kdv, $tutar, $net_tutar, $warehouse;
    public $account_name, $account_code, $account_ref_id;
    public $project_name;
    public $project_code;
    public $birim_select = [];
    public $line = 0;
    public $updateMode = false;
    public $inputs = [];
    public $i = 0;

    protected $listeners = ["getItem", "getAccount", "getProject"];

    public function store()
    {

        $response = Http::withToken(Cookie::get("logo_access_token"))->post('http://65.21.157.111:32001/api/v1/purchaseOrders', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'DATE' => '2021-11-20T00:00:00',
            'CLIENTREF' => $this->account_ref_id,
            'TRANSACTIONS' => [
                'items' => [
                    [
                        "TYPE" => 0,
                        "MASTER_CODE" => "16874",
                        "STOCKREF" => 7116,
                        "CLIENTREF" => $this->account_ref_id,
                        "QUANTITY" => 15.0,
                        "PRICE" => 113.0,
                        "UNIT_CODE" => "ADET",
                        "VAT_RATE" => 8
                    ],
                    [
                        "TYPE" => 0,
                        "MASTER_CODE" => "16806",
                        "STOCKREF" => 7116,
                        "CLIENTREF" => $this->account_ref_id,
                        "QUANTITY" => 15.0,
                        "PRICE" => 113.0,
                        "UNIT_CODE" => "ADET",
                        "VAT_RATE" => 7
                    ],
                ]
            ]
        ])->json();
    }

    public function getItem($d) // seçilen malzemeyi  dinleyerek set ediyoruz 
    {
        $this->line = $d["line"];
        $item = LogoDb::where('logicalref', $d['ref'])->first();
        $units = LogoUnits::Where('UNITSETREF', $item->unit_ref)->get();

        $this->birim_select[$this->line] = $units;


        $this->kod[$this->line] = $item->stock_code;
        $this->aciklama[$this->line] = $item->stock_name;

        $this->dispatchBrowserEvent('CloseModal');
    }

    public function getAccount($d) // seçilen müşteriyi  dinleyerek set ediyoruz 
    {
        $this->account_code = $d['code'];
        $this->account_name = $d['name'];
        $this->account_ref_id = $d['ref_id'];
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function getProject($d) // seçilen projeyi  dinleyerek set ediyoruz 
    {
        $this->project_code = $d['code'];
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function active_line($d)
    {
        $this->line = $d;
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }




    public function render()
    {
        if (isset($this->miktar[$this->line]) && $this->miktar[$this->line] > 0  && isset($this->birim_fiyat[$this->line]) && $this->birim_fiyat[$this->line] > 0) {
            $this->tutar[$this->line] = $this->miktar[$this->line] * $this->birim_fiyat[$this->line];
            $this->net_tutar[$this->line] = $this->miktar[$this->line] * $this->birim_fiyat[$this->line];
        }


        if (isset($this->miktar[$this->line]) && $this->miktar[$this->line] > 0  && isset($this->birim_fiyat[$this->line]) && $this->birim_fiyat[$this->line] > 0  && isset($this->kdv[$this->line]) && $this->kdv[$this->line] > 0) {
            $kdv = $this->kdv[$this->line];
            $tutar = $this->miktar[$this->line] * $this->birim_fiyat[$this->line];
            $this->net_tutar[$this->line] = $tutar;
            $this->tutar[$this->line] = $tutar + ($tutar * ($kdv / 100));
        }


        if (isset($this->miktar[$this->line]) && $this->miktar[$this->line] == 0  || isset($this->birim_fiyat[$this->line]) && $this->birim_fiyat[$this->line] == 0) {
            $this->tutar[$this->line] = null;
        }

        $data = LogoWarehouses::where('company_no', '1')->get();

        return view('livewire.satinalma.siparis', [
            'warehouses' => $data,
        ]);
    }
}
