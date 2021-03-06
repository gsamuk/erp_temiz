<?php

namespace App\Http\Livewire\Malzemeler\Mobile;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\LogoItems;
use App\Models\LogoDb;
use App\Models\LogoItemsPhoto;
use App\Models\LogoUnits;
use App\Models\MobileDemanDetailTemp;
use Illuminate\Support\Facades\Session;
use App\Models\Demand;
use App\Models\DemandDetail;


class Liste extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $search_stock_code;
    public $user_id;
    public $sku;

    public $slc_item_type;
    public $slc_stock_type;
    public $perPage = 6;
    public $malzeme;
    public $malzeme_units;
    public $malzeme_birim;

    public $log = "log burada";
    public $nfc_btn = true;
    public $nfc_active = false;

    public $special_code;



    public $talep_miktar = 1;
    public $talep_neden = "İhtiyaç";


    protected $listeners = ["MalzemeGoster", "GetKod"];

    public function GetKod($d)
    {
        $this->special_code = $d;
        $this->dispatchBrowserEvent('CloseModal', ['modal' => '#KodRight']);
    }

    public function MalzemeGoster()
    {

        if (isset($this->sku)) {
            $this->talep_miktar = 1;
            $this->malzeme = LogoItems::where('stock_code', $this->sku)->first();
            $this->malzeme_photos = LogoItemsPhoto::Where('stock_code', $this->sku)->get();
            $this->malzeme_units = LogoUnits::Where('unitset_ref', $this->malzeme->unitset_ref)->get();
            $this->malzeme_birim = $this->malzeme_units[0]['unit_code'];
            $this->dispatchBrowserEvent('ShowModal', ['modal' => '#MyModal']);
        }
    }

    public function mount()
    {
        $this->user_id = Session::get('userData')->id;
    }

    public function render()
    {
        $malzemeler = LogoItems::where('stock_name', 'like', '%' . $this->search . '%')
            ->where('wh_no', 0)
            ->when(!empty($this->slc_item_type), function ($query) {
                return $query->where('cardtype_name', $this->slc_item_type);
            })
            ->when(!empty($this->search_stock_code), function ($query) {
                return $query->where('stock_code', $this->search_stock_code);
            })
            ->when(!empty($this->slc_stock_type), function ($query) {
                return $query->where('stock_type', $this->slc_stock_type);
            })
            ->orderBy('stock_name', 'desc')
            ->paginate($this->perPage);

        $item_type = LogoDb::select('cardtype_name')->distinct()->get();
        $stock_type = LogoDb::select('stock_type')->distinct()->get();
        $talep_listesi = MobileDemanDetailTemp::where('user_id', $this->user_id)->get();

        return view(
            'livewire.malzemeler.mobile.liste',
            [
                'malzemeler' => $malzemeler,
                'item_type' => $item_type,
                'stock_type' => $stock_type,
                'talep_listesi' => $talep_listesi,
            ]
        );
    }

    public function loadMore()
    {
        $this->perPage += 5;
    }

    public function ekle()
    {
        $db = new MobileDemanDetailTemp;
        $db->user_id = $this->user_id;
        $db->logo_stock_ref = $this->malzeme->logicalref;
        $db->quantity = $this->talep_miktar;
        $db->unit_code = $this->malzeme_birim;
        $db->stock_name = $this->malzeme->stock_name;
        $db->stock_code = $this->malzeme->stock_code;
        $db->average_price = $this->malzeme->average_price;

        $db->description = $this->talep_neden;

        $db->insert_time = date('Y-m-d H:i:s');
        $db->save();
        $this->dispatchBrowserEvent('CloseModalAll');
    }

    public function sil($id)
    {
        MobileDemanDetailTemp::where('id', $id)->where('user_id', $this->user_id)->delete();
        $sayi = MobileDemanDetailTemp::where('user_id', 1)->count();
        if ($sayi == 0) {
            $this->dispatchBrowserEvent('CloseModalAll');
        }
    }


    public function talep_ekle()
    {
        $insert_time = date('Y-m-d H:i:s');
        $demand = new Demand;
        $demand->company_id = 1;
        $demand->users_id = $this->user_id;
        $demand->warehouse_no = 0;
        $demand->demand_type = 1;
        $demand->special_code = $this->special_code;
        $demand->insert_time = $insert_time;
        $demand->save();
        $demand_no = $demand->id; // eklenen id


        $talep_listesi = MobileDemanDetailTemp::where('user_id', $this->user_id)->get();

        foreach ($talep_listesi as $d) {
            $dm = new DemandDetail;
            $dm->demand_id = $demand_no;

            $dm->logo_stock_ref = $d->logo_stock_ref;
            $dm->quantity = $d->quantity;
            $dm->unit_code = $d->unit_code;
            $dm->stock_name = $d->stock_name;
            $dm->stock_code = $d->stock_code;
            $dm->average_price = $d->average_price;

            $dm->description = $d->description;
            $dm->insert_time = $insert_time;
            $dm->update_time = $insert_time;
            $dm->save();
        }
        MobileDemanDetailTemp::where('user_id', $this->user_id)->delete();
        $this->dispatchBrowserEvent('CloseModalAll');
    }

    public function getMalzeme($sku)
    {

        $this->talep_miktar = 1;
        $this->malzeme = LogoItems::where('stock_code', "$sku")->first();
        $this->malzeme_photos = LogoItemsPhoto::Where('stock_code', "$sku")->get();

        $this->malzeme_units = LogoUnits::Where('unitset_ref', $this->malzeme->unitset_ref)->get();
        $this->malzeme_birim = $this->malzeme_units[0]['unit_code'];
        $this->dispatchBrowserEvent('ShowModal', ['modal' => '#MyModal']);
    }
}