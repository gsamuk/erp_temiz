<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;

use App\Models\LogoDb;
use App\Models\LogoUnits;
use App\Models\LogoWarehouses;
use App\Http\Controllers\LogoRest;
use App\Http\Controllers\DbController;
use App\Models\LogoItemsPhoto;
use App\Models\Demand;
use App\Models\DemandDetail;
use App\Helpers\Erp;

class TalepOlustur extends Component
{
    public $line = 0;
    public $i = 0;
    public $inputs = [];

    public $ref;

    public $special_code;
    public $project_code;

    public $kod;
    public $aciklama;
    public $miktar;
    public $birim;
    public $average_price;
    public $ozelkod; // satır bazlı


    public $desc;

    public $birim_select = [];
    public $tid = 0; // talep  id
    public $item_photos;


    public $zaman;
    public $demand_desc;

    public $demand_type = 1;

    public $warehouse = 0; // malzemenin çıktığı depo
    public $destwh;  // malzemenin girdiği depo



    protected $listeners = ["getItem", "getOzelKod", "getOzelKodLine", "getProject"];

    public function updatedWarehouse($id)
    {
        $this->emit('setWh', $id);

        $this->kod = null;
        $this->aciklama = null;
        $this->average_price = null;
        $this->miktar = null;
        $this->birim = null;
        $this->ozelkod = null;
        $this->birim_select = [];

        $this->line = 0;
        $this->i = 0;
        $this->inputs = [];
    }

    public function mount()
    {
        // $this->add(1);
        date_default_timezone_set('Europe/Istanbul');
        $this->zaman = date("2021-m-d");
    }



    public function SetLine($d, $modal)
    {
        $this->line = $d;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => $modal]);
    }

    public function _SetLine($d, $modal) // sadece satır özel kod için kullanılyor
    {
        $this->line = $d;
        $this->emit('ozelKodType', 2);
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => $modal]);
    }

    public function getOzelKod($d)
    {
        $d = json_decode($d);
        $this->special_code = $d->special_code;
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function getOzelKodLine($d)
    {
        $d = json_decode($d);
        $this->ozelkod[$this->line] = $d->special_code;
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function getProject($d)
    {
        $d = json_decode($d);
        $this->project_code = $d->project_code;
        $this->dispatchBrowserEvent('CloseModal');
    }



    public function render()
    {
        // 1 Nolu firmanın depoları gelir
        $data = LogoWarehouses::where('company_no', '1')->get();
        return view(
            'livewire.malzemeler.talep-olustur',
            [
                'warehouses' => $data,
            ]
        );
    }


    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
        $this->ozelkod[$i] = $this->special_code;
    }

    public function remove($i, $v)
    {
        unset($this->inputs[$i]);
        unset($this->kod[$v]);
        unset($this->ozelkod[$v]);
        unset($this->item_photos[$v]);
    }



    public function getItem($d) // seçilen malzemeyi  dinleyerek set ediyoruz 
    {

        $item = (object) $d;

        $photos = LogoItemsPhoto::where('logo_stockref', $item->logicalref)->first();
        if ($photos) {
            $this->item_photos[$this->line] = $photos;
        }

        $units = LogoUnits::Where('unitset_ref', $item->unitset_ref)->get();
        $this->birim_select[$this->line] = $units;
        $this->birim[$this->line] = $units[0]['unit_code'];

        $this->ref[$this->line] = $item->logicalref;
        $this->kod[$this->line] = $item->stock_code;
        $this->aciklama[$this->line] = $item->stock_name;
        $this->average_price[$this->line] = $item->average_price;
        $this->desc[$this->line] = "İhtiyaç";
        $this->miktar[$this->line] = 1; // test verisi
        $this->dispatchBrowserEvent('CloseModal');
    }


    public function store()
    {
        if ($this->warehouse == $this->destwh && $this->demand_type == 2) {
            return session()->flash('error', 'Transfer için depoları farklı seçmelisiniz.');
        }

        $insert_time = date('Y-m-d H:i:s');

        $demand = new Demand;
        $demand->company_id = 1;
        $demand->users_id = Erp::user_id();
        $demand->warehouse_no = $this->warehouse;
        $demand->demand_desc = $this->demand_desc;
        $demand->project_code = $this->project_code;
        $demand->special_code = $this->special_code;
        $demand->demand_type = $this->demand_type;

        if ($this->destwh) {
            $demand->dest_wh_no = $this->destwh;
        }
        $demand->insert_time = $insert_time;
        $demand->save();

        $demand_no = $demand->id; // eklenen id


        foreach ($this->kod  as $in => $v) {

            if (!isset($this->miktar[$in]) || $this->miktar[$in] == null) {
                return session()->flash('error', 'Miktar Giriniz');
            }

            if (!isset($this->birim[$in]) || $this->birim[$in] == null) {
                return session()->flash('error', 'Birim Seçiniz');
            }
            $dm = new DemandDetail;

            $dm->demand_id = $demand_no;
            $dm->stock_code = $this->kod[$in];

            $dm->logo_stock_ref = $this->ref[$in];
            $dm->quantity = $this->miktar[$in];
            $dm->unit_code = $this->birim[$in];

            $dm->average_price = $this->average_price[$in];
            $dm->stock_name = $this->aciklama[$in];

            if (isset($this->ozelkod[$in])) {
                $dm->special_code = $this->ozelkod[$in];
            }

            if (isset($this->desc[$in])) {
                $dm->description = $this->desc[$in];
            }
            $dm->insert_time = $insert_time;
            $dm->update_time = $insert_time;
            $dm->save();
        }

        $this->reset();
        return session()->flash('success', $demand_no . ' Belege Numaralı Malzeme Talebi Oluşturuldu.');
    }
}