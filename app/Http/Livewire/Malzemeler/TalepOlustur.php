<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;


use App\Models\LogoUnits;
use App\Models\LogoWarehouses;

use App\Models\LogoItemsPhoto;
use App\Models\Demand;
use App\Models\DemandDetail;
use App\Models\UserCompany;
use App\Helpers\Erp;
use App\Models\LogoDb;
use App\Models\Users;

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

    //// edit için
    public $edit_id;

    // kullanıcılar
    public $user_id; // talep sahibi user_id





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
        $this->user_id = Erp::user_id(); // default 


        date_default_timezone_set('Europe/Istanbul');
        $this->zaman = date("d/m/Y");

        if ($this->edit_id) {
            $this->LoadDemand();
        } else {
            $this->add(1);
        }
    }



    public function SetLine($d, $modal)
    {
        $this->line = $d;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => $modal]);
    }

    public function _SetLine($d, $modal)
    {
        $this->emit('ozelKodType', 2);
        $this->line = $d;
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

    public function LoadDemand()
    {
        if ($this->edit_id) {
            $talep = Demand::find($this->edit_id);
            $this->warehouse = $talep->warehouse_no;
            $this->demand_desc =  $talep->demand_desc;
            $this->project_code = $talep->project_code;
            $this->special_code =  $talep->special_code;
            $this->demand_type = $talep->demand_type;
            if ($talep->dest_wh_no) {
                $this->destwh = $talep->dest_wh_no;
            }

            $items = DemandDetail::Where('demand_id', $this->edit_id)->get();
            foreach ($items as $i => $val) {
                $this->i = $i;
                $this->inputs[] = $i;
                $this->kod[$i] = $val->stock_code;
                $this->desc[$i] = $val->description;
                $this->aciklama[$i] = $val->stock_name;
                $this->ref[$i] =  $val->logo_stock_ref;
                $this->miktar[$i] = Erp::nmf($val->quantity);
                $this->ozelkod[$i] =  $val->special_code;
                $this->birim[$i] =  $val->unit_code;
                $this->average_price[$i] = $val->average_price;

                $ml = LogoDb::where('stock_code', $val->stock_code)->first();
                $units = LogoUnits::Where('unitset_ref', $ml->unitset_ref)->get();
                $this->birim_select[$i] = $units;
                $this->birim[$i] = $val->unit_code;


                $photos = LogoItemsPhoto::where('logo_stockref', $ml->logicalref)->first();
                if ($photos) {
                    $this->item_photos[$i] = $photos;
                }
            }
        }
    }


    public function render()
    {

        // 1 Nolu firmanın depoları gelir
        $warehouses = LogoWarehouses::where('company_no', '1')->get();
        $auth_warehouses = UserCompany::where('company_id', '1')
            ->Where('user_id', Erp::user_id())
            ->get();

        return view(
            'livewire.malzemeler.talep-olustur',
            [
                'warehouses' => $warehouses,
                'auth_warehouses' => $auth_warehouses,
            ]
        );
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
        $this->miktar[$this->line] = 0; // test verisi
        $this->ozelkod[$this->line] = $this->special_code;
        $this->dispatchBrowserEvent('CloseModal');
    }


    public function store()
    {
        if ($this->warehouse == $this->destwh && $this->demand_type == 2) {
            return session()->flash('error', 'Transfer için depoları farklı seçmelisiniz.');
        }

        $date = str_replace('/', '-', $this->zaman);
        $insert_time = date("Y-m-d", strtotime($date));

        $demand = new Demand;
        $demand->company_id = 1;
        $demand->users_id = $this->user_id;
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
            $dm->approved_consump = $this->miktar[$in];
            $dm->special_code = $this->ozelkod[$in];
            $dm->unit_code = $this->birim[$in];

            $dm->average_price = $this->average_price[$in];
            $dm->stock_name = $this->aciklama[$in];



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