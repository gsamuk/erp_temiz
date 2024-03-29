<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;
use App\Models\Demand;
use App\Models\DemandDetail;
use App\Models\LogoItems;
use App\Models\LogoItemsPhoto;
use App\Http\Controllers\LogoRest;
use App\Models\DemandFiche;
use App\Models\IncompletedDemand;
use App\Helpers\Erp;


class TalepIslem extends Component
{
    public $error;
    public $talep;
    public $talep_id;
    public $talep_owner = false;

    public $talep_detay;
    public $talep_;
    public $demand_fiche;

    public $item;
    public $item_id;
    public $item_photos;

    public $sarf = array();

    // malzeme durum statusu değiştirmek için
    public $stock_code;
    public $status_text;

    /// fiş işlemleri
    public $sarf_fis_ref;
    public $satinalma_fis_ref;

    /// talep sahibi bilgileri
    public $tuser;

    protected $listeners = ['TalepIslem', 'RefreshTalepIslem' => '$refresh'];


    public function TalepIslem($id)
    {
        $this->error = null;
        $this->sarf_fis_ref = null;
        $this->talep_id = $id;
        $this->talep = Demand::find($id);
        $this->tuser = Erp::user($this->talep->users_id);
        $this->talep_detay = DemandDetail::Where('demand_id', $id)->Where('status', '!=', 9)->get();
        if ($this->talep_detay->count() == 0) {
            $this->talep_detay = null;
        }
    }


    public function tek_sarf_olustur($stock_code)
    {
        $demand_item = IncompletedDemand::Where('demand_id', $this->talep_id)->where('stock_code', $stock_code)->first();
        $item = LogoItems::Where("stock_code", "$stock_code")->first();
        $rest_items = array();
        $rest_items[] = [
            "ITEM_CODE" => $item->stock_code,
            "ITEMREF" => $item->logicalref,
            "UNIT_CODE" => $demand_item->unit_code,
            "PRICE" => $item->average_price,
            "TYPE" => 25,
            'QUANTITY' => $demand_item->diff,
            'SOURCEINDEX' => $this->talep->warehouse_no,
            'SOURCECOSTGRP' => $this->talep->warehouse_no,
        ];

        $sarf_data = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'DATE' => date('Y-m-d H:i:s'),
            'GROUP' => 2,
            "AUXIL_CODE" => $demand_item->special_code,
            "PROJECT_CODE" => $this->talep->project_code,
            "FOOTNOTE1"  => $this->talep->demand_desc,
            'DOC_NUMBER' => "SF" . $this->talep_id,
            "TYPE" => 12,
            'IO_TYPE' => 3,
            'SOURCE_WH' => $this->talep->warehouse_no,
            'SOURCE_COST_GRP' => 1,
            'TRANSACTIONS' => [
                'items' => $rest_items
            ]
        ];


        $logo_fiche_ref  = LogoRest::SarfFisiOlustur($sarf_data, 0);
        if ($logo_fiche_ref != null) {

            $dm = new DemandFiche;
            $dm->demand_id = $this->talep_id;
            $dm->logo_fiche_ref = $logo_fiche_ref;
            $dm->demand_type = 1;
            $dm->fiche_type = 1;
            $dm->insert_time = date('Y-m-d H:i:s');
            $dm->save();
            DemandDetail::find($demand_item->demand_detail_id)->increment('approved_consump', $demand_item->diff);

            $kalan = IncompletedDemand::where('demand_id', $this->talep_id)->count();
            if ($kalan == 0) {
                $d = Demand::find($this->talep_id);
                $d->status = 2;
                $d->save();
                $this->emit('RefreshTalepListesi');
            }

            $this->emit('RefreshTalepIslem');

            return session()->flash('success', 'Logo Sarf Fişi Oluşturuldu.');
        }
    }



    public function transfer_olustur()
    {
        $rest_items = array();
        $demand = Demand::find($this->talep_id);
        foreach ($this->sarf as $stock_code => $miktar) {
            if ($miktar > 0) {
                $demand_item = IncompletedDemand::Where('demand_id', $this->talep_id)->where('stock_code', $stock_code)->first();
                $item = LogoItems::Where("stock_code", "$stock_code")->first();

                $rest_items[] = [
                    "ITEM_CODE" => $item->stock_code,
                    "ITEMREF" => $item->logicalref,
                    "UNIT_CODE" => $demand_item->unit_code,
                    "PRICE" => $item->average_price,
                    "TYPE" => 25,
                    'QUANTITY' => $miktar,
                    'SOURCEINDEX' =>  $demand->warehouse_no,
                    'DESTINDEX' => $demand->dest_wh_no,
                ];
            }
        }

        if (count($rest_items) == 0) {
            return session()->flash('error', 'Lütfen Malzeme Seçiniz');
        }


        $sarf_data = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'DATE' => date('Y-m-d H:i:s'),
            'GROUP' => 3,
            "SOURCE_WH" => $demand->warehouse_no,
            "SOURCE_COST_GRP" => $demand->warehouse_no,
            "DEST_WH" => $demand->dest_wh_no,
            "DEST_COST_GRP" => $demand->dest_wh_no,
            'DOC_NUMBER' => "TR" . $this->talep_id,
            "TYPE" => 25,
            'IO_TYPE' => 2,
            'TRANSACTIONS' => [
                'items' => $rest_items
            ]
        ];

        $logo_fiche_ref  = LogoRest::SarfFisiOlustur($sarf_data, 0);
        if ($logo_fiche_ref != null) {

            $dm = new DemandFiche;
            $dm->demand_id = $this->talep_id;
            $dm->logo_fiche_ref = $logo_fiche_ref;
            $dm->demand_type = $demand->demand_type;
            $dm->fiche_type = 3;
            $dm->insert_time = date('Y-m-d H:i:s');
            $dm->save();
            DemandDetail::find($demand_item->demand_detail_id)->increment('approved_consump', $demand_item->diff);


            $this->sarf = null;

            $kalan = IncompletedDemand::where('demand_id', $this->talep_id)->count();
            if ($kalan == 0) {
                $d = Demand::find($this->talep_id);
                $d->status = 2;
                $d->save();
            }
            $this->emit('RefreshTalepListesi');
            return session()->flash('success', 'Logo Sarf Fişi Oluşturuldu.');
        }
    }


    public function render()
    {
        return view('livewire.malzemeler.talep-islem');
    }

    public function foto_goster($id)
    {
        $this->item_id = $id;
        $this->item = LogoItems::find($id);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $id)->get();
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#MalzemeFotoModal']);
    }

    public function status_pop($stock_code, $desc)
    {
        $this->stock_code = $stock_code;
        $this->status_text = $desc;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#setStatusModal']);
    }

    public function update_status()
    {
        $up = DemandDetail::Where("stock_code", $this->stock_code)
            ->where("demand_id", $this->talep_id)->first();
        $up->status_desc = $this->status_text;
        $up->save();
        $this->dispatchBrowserEvent('CloseModal');
    }


    public function esitle($stock_code, $consump)
    {
        $up = DemandDetail::Where("stock_code", $stock_code)->where("demand_id", $this->talep_id)->first();
        $up->quantity = $consump;
        $up->save();
    }
}