<?php

namespace App\Http\Livewire\Satinalma;

use Livewire\Component;
use App\Models\LogoDb;
use App\Models\LogoUnits;
use App\Models\LogoWarehouses;
use App\Http\Controllers\LogoRest;
use App\Http\Controllers\DbController;


class SiparisOlustur extends Component
{

    public $tip, $kod, $aciklama, $miktar, $indirim, $birim, $birim_fiyat, $kdv, $kdv_inc, $tutar, $net_tutar, $warehouse;
    public $zaman;
    public $belge_no;
    public $account_name, $account_code, $account_ref_id;

    public $project_name;
    public $project_ref_id;
    public $project_code;

    public $birim_select = [];
    public $line = 0;
    public $updateMode = false;
    public $inputs = [];
    public $i = 0;
    public $sid; // sipariş id

    public $toplam = 0;
    public $toplam_kdv = 0;
    public $net_toplam = 0;



    protected $listeners = ["getItem", "getAccount", "getProject"];


    public function SetLine($d, $modal)
    {
        $this->line = $d;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => $modal]);
    }

    public function updated($name, $value)
    {
        $konum = strpos($name, 'birim_fiyat');

        if ($konum !== false) {
            $ln = explode('.', $name);
            $ln = $ln[1];
            if (!empty($this->miktar[$ln])) {
                $tutar = $this->birim_fiyat[$ln] * $this->miktar[$ln];
                $this->tutar[$ln] = $tutar;
                if (!empty($this->kdv[$ln]) && $this->kdv_inc[$ln] == 0) {
                    $kdv = $tutar * $this->kdv[$ln] / 100;
                    $net_tutar = $kdv + $tutar;
                    $this->net_tutar[$ln] = $net_tutar;
                } else if (!empty($this->kdv[$ln]) && $this->kdv_inc[$ln] == 1) {
                    $kdvSiz = $tutar / (1 + ($this->kdv[$ln] / 100));
                    $this->net_tutar[$ln] = number_format($kdvSiz, 2, ',', '.');
                } else {
                    $this->net_tutar[$ln] = $tutar;
                }
            }
        }

        $konum_kdv = strpos($name, 'kdv');
        if ($konum_kdv !== false) {
            $ln = explode('.', $name);
            $ln = $ln[1];
            if (!empty($this->miktar[$ln])) {
                $tutar = $this->birim_fiyat[$ln] * $this->miktar[$ln];
                $this->tutar[$ln] = $tutar;
                if (!empty($this->kdv[$ln]) && $this->kdv_inc[$ln] == 0) {
                    $kdv = $tutar * $this->kdv[$ln] / 100;
                    $net_tutar = $kdv + $tutar;
                    $this->net_tutar[$ln] = $net_tutar;
                } else if (!empty($this->kdv[$ln]) && $this->kdv_inc[$ln] == 1) {
                    $kdvSiz = $tutar / (1 + ($this->kdv[$ln] / 100));
                    $this->net_tutar[$ln] = number_format($kdvSiz, 2, ',', '.');
                } else {
                    $this->net_tutar[$ln] = $tutar;
                }
            }
        }

        $konum_miktar = strpos($name, 'miktar');
        if ($konum_miktar !== false) {
            $ln = explode('.', $name);
            $ln = $ln[1];
            if (!empty($this->birim_fiyat[$ln])) {
                $tutar = $this->birim_fiyat[$ln] * $this->miktar[$ln];
                $this->tutar[$ln] = $tutar;
                if (!empty($this->kdv[$ln]) && $this->kdv_inc[$ln] == 0) {
                    $kdv = $tutar * $this->kdv[$ln] / 100;
                    $net_tutar = $kdv + $tutar;
                    $this->net_tutar[$ln] = $net_tutar;
                } else if (!empty($this->kdv[$ln]) && $this->kdv_inc[$ln] == 1) {
                    $kdvSiz = $tutar / (1 + ($this->kdv[$ln] / 100));
                    $this->net_tutar[$ln] = number_format($kdvSiz, 2, ',', '.');
                } else {
                    $this->net_tutar[$ln] = $tutar;
                }
            }
        }


        $this->dispatchBrowserEvent('Hesapla');
    }



    public function mount()
    {
        date_default_timezone_set('Europe/Istanbul');
        $this->zaman = date("Y-m-d");
        if ($this->sid > 0) {
            $data = DbController::getSiparis($this->sid);
            $this->zaman = date('Y-m-d', strtotime($data->po_date));
            $this->belge_no = $data->document_no;
            $this->project_code = $data->project_code;
            $this->project_ref_id = $data->po_projectref;

            $this->account_code = $data->acoount_code;
            $this->account_name = $data->account_name;
            $this->account_ref_id = $data->accountref;
            $this->warehouse = $data->po_warehouseref;
            $this->toplam = $data->total_gross;
            $this->toplam_kdv = $data->total_vat;
            $this->net_toplam = $data->total_amount;

            $items = DbController::getSiparisDetay($this->sid);

            foreach ($items as $itm => $v) {

                $this->i = $itm;
                $this->inputs[] = $itm;
                $this->aciklama[$itm] = $v->stock_name;
                $this->kod[$itm] = $v->stock_code;
                $this->miktar[$itm] = $v->quantity;
                $this->birim[$itm] = $v->unit_code;
                $this->birim_fiyat[$itm] = $v->unit_price;
                $this->kdv_inc[$itm] = $v->vat_included;
                $this->kdv[$itm] = $v->vat;

                $ml = LogoDb::where('stock_code', $v->stock_code)->first();
                $units = LogoUnits::Where('unitset_ref', $ml->unitset_ref)->get();
                $this->birim_select[$itm] = $units;
                $this->birim[$itm] = $v->unit_code;
            }
        }
    }

    public function store($sid)
    {

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


            $items[] = [
                "TYPE" => 0,
                "MASTER_CODE" => $this->kod[$in],
                "CLIENTREF" => $this->account_ref_id,
                'PROJECT_CODE' => $this->project_code,
                'PROJECTREF' => $this->project_ref_id,
                "QUANTITY" => $this->miktar[$in],
                "PRICE" => $this->birim_fiyat[$in],
                "UNIT_CODE" => $this->birim[$in],
                "VAT_INCLUDED" => $this->kdv_inc[$in],
                "VAT_RATE" => $kdv_,
            ];
        }

        $data = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'DATE' => $this->zaman,
            'CLIENTREF' => $this->account_ref_id,
            "ARP_CODE" => $this->account_code,
            'DOC_NUMBER' => $this->belge_no,
            'SOURCE_WH' => $this->warehouse,
            'PROJECT_CODE' => $this->project_code,
            'PROJECTREF' => $this->project_ref_id,
            'TRANSACTIONS' => [
                'items' => $items
            ]
        ];



        LogoRest::SiparisOlustur($data, $sid);

        //$this->reset();
    }

    public function getItem($d) // seçilen malzemeyi  dinleyerek set ediyoruz 
    {
        $item = (object) $d;

        $units = LogoUnits::Where('unitset_ref', $item->unitset_ref)->get();
        $this->birim_select[$this->line] = $units;
        $this->birim[$this->line] = $units[0]['unit_code'];


        $this->kod[$this->line] = $item->stock_code;
        $this->aciklama[$this->line] = $item->stock_name;
        $this->kdv_inc[$this->line] = 0;

        $this->dispatchBrowserEvent('CloseModal');
    }

    public function getAccount($d) // seçilen müşteriyi  dinleyerek set ediyoruz 
    {
        $d = json_decode($d);
        $this->account_code = $d->account_code;
        $this->account_name = $d->account_name;
        $this->account_ref_id = $d->ref_id;
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function getProject($d) // seçilen projeyi  dinleyerek set ediyoruz 
    {
        $d = json_decode($d);
        $this->project_code = $d->project_code;
        $this->project_ref_id = $d->project_ref;
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

    public function remove($i, $v)
    {
        unset($this->inputs[$i]);
        unset($this->kod[$v]);
    }


    public function render()
    {
        $data = LogoWarehouses::where('company_no', '1')->get();
        return view('livewire.satinalma.siparis-olustur', [
            'warehouses' => $data,
        ]);
    }
}
