<?php

namespace App\Http\Livewire\Satinalma;

use Livewire\Component;
use App\Models\LogoDb;
use App\Models\LogoUnits;
use App\Models\LogoWarehouses;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Siparis extends Component
{

    public $tip, $kod, $aciklama, $miktar, $birim, $birim_fiyat, $kdv, $tutar, $net_tutar, $warehouse;
    public $zaman;
    public $belge_no;
    public $account_name, $account_code, $account_ref_id;
    public $project_name;
    public $project_code;
    public $birim_select = [];
    public $line = 0;
    public $updateMode = false;
    public $inputs = [];
    public $i = 0;



    protected $listeners = ["getItem", "getAccount", "getProject"];

    protected $rules = [
        'account_ref_id' => 'required',
    ];
    protected $messages = [
        'account_ref_id.required' => 'Lütfen Cari Ünvan Seçiniz',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        date_default_timezone_set('Europe/Istanbul');
        $this->zaman = date("Y-m-d");
    }

    public function store()
    {


        $this->validate();
        $items = array();

        foreach ($this->kod  as $in => $v) {
            if (!isset($this->kdv[$in]) || $this->kdv[$in] == null) {
                $kdv_ = NULL;
            } else {
                $kdv_ = $this->kdv[$in];
            }

            if (!isset($this->miktar[$in]) || $this->miktar[$in] == null) {
                return session()->flash('error', 'Miktar Giriniz');
            }

            if (!isset($this->birim[$in]) || $this->birim[$in] == null) {
                return session()->flash('error', 'Birim Seçiniz');
            }

            if (!isset($this->birim_fiyat[$in]) || $this->birim_fiyat[$in] == null) {
                return session()->flash('error', 'Birim Fiyatları Giriniz');
            }

            $items[$in] = [
                "TYPE" => 0,
                "MASTER_CODE" => $this->kod[$in],
                "CLIENTREF" => $this->account_ref_id,
                "QUANTITY" => $this->miktar[$in],
                "PRICE" => $this->birim_fiyat[$in],
                "UNIT_CODE" => $this->birim[$in],
                "VAT_RATE" => $kdv_,
            ];
        }

        try {
            $response = Http::withToken(Cookie::get("logo_access_token"))->post('http://65.21.157.111:32001/api/v1/purchaseOrders', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'DATE' => $this->zaman,
                'CLIENTREF' => $this->account_ref_id,
                'DOC_NUMBER' => $this->belge_no,
                'TRANSACTIONS' => [
                    'items' => $items
                ]
            ]);
            if ($response->status() == 200 && $response->successful() == true) {
                $this->reset();
                return session()->flash('success', 'Başarılı Sipariş ID #' . $response->json("INTERNAL_REFERENCE"));
            } else {
                //dd($response->json('ModelState')['ValError0']);
                return session()->flash('error', $response->getreasonPhrase());
            }
        } catch (Exception $e) {
            return session()->flash('error', $e->getMessage());
        }
    }

    public function getItem($d) // seçilen malzemeyi  dinleyerek set ediyoruz 
    {

        $this->line = $d["line"];
        $item = LogoDb::where('logicalref', $d['ref'])->first();

        $units = LogoUnits::Where('unitset_ref', $item->unitset_ref)->get();
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
