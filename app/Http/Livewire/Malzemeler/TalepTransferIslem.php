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


class TalepTransferIslem extends Component
{
    public $error;
    public $talep;
    public $talep_id;
    public $talep_detay;
    public $talep_;
    public $demand_fiche;

    public $item;
    public $item_id;
    public $item_photos;

    public $sarf = array();

    protected $listeners = ['TalepTransferIslem'];

    public function TalepTransferIslem($id)
    {
        $this->error = null;
        $this->talep_id = $id;
        $this->talep = Demand::find($id);
        $this->talep_detay = DemandDetail::Where('demand_id', $id)->Where('status', '!=', 9)->get();
        if ($this->talep_detay->count() == 0) {
            $this->talep_detay = null;
        }
    }


    public function transfer_olustur()
    {
        $transfer_items = array();

        if (count($this->sarf) == 0) {
            return session()->flash('error', 'Lütfen Malzeme Seçiniz');
        }

        foreach ($this->sarf as $stock_code => $miktar) {
            if ($miktar > 0) {
                $demand_item = IncompletedDemand::Where('demand_id', $this->talep_id)->where('stock_code', $stock_code)->first();
                $item = LogoItems::Where("stock_code", "$stock_code")->first();

                $demand = Demand::find($this->talep_id);

                $transfer_items[] = [
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

        $demand = Demand::find($this->talep_id);
        $sarf_data = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'DATE' => "2021-05-21 10:10:00",
            'GROUP' => 3,
            "SOURCE_WH" => $demand->warehouse_no,
            "SOURCE_COST_GRP" => $demand->warehouse_no,
            "DEST_WH" => $demand->dest_wh_no,
            "DEST_COST_GRP" => $demand->dest_wh_no,
            'DOC_NUMBER' => "TR" . $this->talep_id,
            "TYPE" => 25,
            'IO_TYPE' => 2,
            'TRANSACTIONS' => [
                'items' => $transfer_items
            ]
        ];


        if (count($transfer_items) > 0) {

            $logo_fiche_ref  = LogoRest::SarfFisiOlustur($sarf_data, 0);

            if ($logo_fiche_ref != null && $logo_fiche_ref > 0) {

                $dm = new DemandFiche;
                $dm->demand_id = $this->talep_id;
                $dm->logo_fiche_ref = $logo_fiche_ref;
                $dm->insert_time = date('Y-m-d H:i:s');
                $dm->save();

                $this->sarf = null;

                $kalan = IncompletedDemand::where('demand_id', $this->talep_id)->count();
                if ($kalan == 0) {
                    $d = Demand::find($this->talep_id);
                    $d->status = 2;
                    $d->save();
                }

                return session()->flash('success', 'Logo Sarf Fişi Oluşturuldu.');
            }
        }
    }

    public function render()
    {
        return view('livewire.malzemeler.talep-transfer-islem');
    }

    public function foto_goster($id)
    {
        $this->item_id = $id;
        $this->item = LogoItems::find($id);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $id)->get();
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#MalzemeFotoModal']);
    }
}