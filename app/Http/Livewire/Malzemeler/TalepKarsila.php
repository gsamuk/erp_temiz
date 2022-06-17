<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;
use App\Models\DemandDetail;
use App\Models\Demand;
use App\Models\DemandFiche;
use App\Models\LogoItemsPhoto;
use App\Models\LogoItems;
use App\Http\Controllers\LogoRest;


class TalepKarsila extends Component
{
    public $talep;
    public $talep_detay;
    public $talep_id;
    public $error;
    public $iptal_sebep = "Gerekli Değil";

    public $for_manage = true; // yönetim durumu aktif , onay işlemleri aktif olur

    public $talep_line;


    public $karsila;
    public $satinal;

    public $item;
    public $item_id;
    public $item_photos;
    public $uyari = false;

    public $iptal_id;

    protected $listeners = ['TalepKarsila' => 'TalepKarsila'];

    public function TalepKarsila($id)
    {
        $this->error = null;
        $this->talep_id = $id;
        $this->talep = Demand::find($id);
        $this->talep_detay = DemandDetail::Where('demand_id', $id)->Where('status', '!=', 9)->get();
        if ($this->talep_detay->count() == 0) {
            $this->talep_detay = null;
        }
    }

    public function iptal($id)
    {
        $this->iptal_id = $id;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#iptalModal']);
    }


    public function cikar($id)
    {
        $up = DemandDetail::find($id);
        $up->status = 9;
        $up->cancel_reason = $this->iptal_sebep;
        $up->save();

        $count = DemandDetail::Where('demand_id', $this->talep_id)->Where('status', '!=', 9)->count();

        if ($count == 0) {
            $up = Demand::find($this->talep_id);
            $up->status = 9;
            $up->save();
            $this->talep_detay = null;
        }

        unset($this->karsila[$this->talep_id][$id]);
        unset($this->satinal[$this->talep_id][$id]);
        $this->TalepKarsila($this->talep_id);

        if ($count == 0) {
            $this->dispatchBrowserEvent('TalepRedToast');
        }

        $this->dispatchBrowserEvent('CloseModal');
    }

    public function unapproved()
    {

        DemandDetail::Where("demand_id", $this->talep_id)->update(["approved_purchase" => null, "approved_consump" => null]);

        $dm = Demand::find($this->talep_id);
        $dm->approved = 0;
        $dm->save();

        $this->TalepKarsila($this->talep_id);
    }

    public function approved()
    {
        if ($this->karsila[$this->talep_id]) {
            foreach ($this->karsila[$this->talep_id] as $item_id => $miktar) {
                if ($miktar > 0) {
                    $item = DemandDetail::find($item_id);
                    $item->approved_consump = $miktar;
                    $item->save();
                }
            }
        }

        if ($this->satinal[$this->talep_id]) {
            foreach ($this->satinal[$this->talep_id] as $item_id => $miktar) {
                if ($miktar > 0) {
                    $item = DemandDetail::find($item_id);
                    $item->approved_purchase = $miktar;
                    $item->save();
                }
            }
        }

        $dm = Demand::find($this->talep_id);
        $dm->approved = 1;
        $dm->save();

        $this->TalepKarsila($this->talep_id);
    }

    public function kaydet()
    {
        $sarf_items = array();
        $satinal_items = array();
        $logo_po_ref = null;
        $logo_fiche_ref = null;
        $this->error = null;


        if ($this->karsila[$this->talep_id]) {
            foreach ($this->karsila[$this->talep_id] as $item_id => $miktar) {
                if ($miktar > 0) {
                    $item = DemandDetail::find($item_id);
                    $item->status = 1; // stoktan karşılama
                    $item->save();
                    $logo_item = LogoItems::find($item->logo_stock_ref);

                    $sarf_items[] = [
                        "ITEM_CODE" => $item->stock_code,
                        "ITEMREF" => $item->logo_stock_ref,
                        "UNIT_CODE" => $item->unit_code,
                        "DESCRIPTION" => $item->description,
                        "PRICE" => $logo_item->average_price,
                        "TYPE" => 25,
                        'QUANTITY' => $miktar,
                    ];
                }
            }
        }


        if ($this->satinal[$this->talep_id]) {
            foreach ($this->satinal[$this->talep_id] as $item_id => $miktar) {
                if ($miktar > 0) {
                    $item = DemandDetail::find($item_id);

                    if ($item->status == 1) { // eğer stoktan karşılama varsa
                        $item->status = 3;  // hep stok hem satınalma statusu
                    } else {
                        $item->status = 2; // sadece satın alma statusu
                    }

                    $item->save();
                    $satinal_items[] = [
                        "STOCKREF" => $item->logo_stock_ref,
                        "UNIT_CODE" => $item->unit_code,
                        "TYPE" => 0,
                        'QUANTITY' => $miktar,
                    ];
                }
            }
        }


        $demand = Demand::find($this->talep_id);
        $sarf_data = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'DATE' => "2021-05-21 10:10:00",
            'GROUP' => 2,
            "AUXIL_CODE" => $demand->special_code,
            "PROJECT_CODE" => $demand->project_code,
            "FOOTNOTE1"  => $demand->demand_desc,
            'DOC_NUMBER' => "SF" . $this->talep_id,
            "TYPE" => 12,
            'IO_TYPE' => 3,
            'SOURCE_WH' => $demand->warehouse_no,
            'SOURCE_COST_GRP' => 1,
            'TRANSACTIONS' => [
                'items' => $sarf_items
            ]
        ];


        $satinal_data = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'DATE' => "2021-05-21 10:10:00",
            'DOC_NUMBER' => "TLP" . $this->talep_id,
            'CLIENTREF' => 7,
            "TYPE" => 2,
            'SOURCE_WH' => $demand->warehouse_no,
            'TRANSACTIONS' => [
                'items' => $satinal_items
            ]
        ];



        if (count($sarf_items) > 0) {

            $logo_fiche_ref  = LogoRest::SarfFisiOlustur($sarf_data, 0);
            
            if ($logo_fiche_ref != null && $logo_fiche_ref > 0 ) {

                $dm = new DemandFiche;
                $dm->demand_id = $this->talep_id;
                $dm->logo_fiche_ref = $logo_fiche_ref;
                $dm->insert_time = date('Y-m-d H:i:s');
                $dm->save();

                $dm = Demand::find($this->talep_id);               
                $dm->status = 1;
                $dm->save();
                
            } else {
                DemandDetail::Where("demand_id", $this->talep_id)->Where("status", 1)->update(["status" => 0]);
                DemandDetail::Where("demand_id", $this->talep_id)->Where("status", 3)->update(["status" => 2]);
            }
        }

        if (count($satinal_items) > 0) {

            $logo_po_ref  = LogoRest::SiparisOlustur($satinal_data, 0);

            if ($logo_po_ref != null) {

                $dm = Demand::find($this->talep_id);
                $dm->logo_po_ref = $logo_po_ref;
                $dm->status = 1;
                $dm->save();

            } else {
                DemandDetail::Where("demand_id", $this->talep_id)->Where("status", 2)->update(["status" => 0]);
                DemandDetail::Where("demand_id", $this->talep_id)->Where("status", 3)->update(["status" => 1]);
            }
        }

        if ($logo_po_ref == null && $logo_fiche_ref == NULL) {
            $this->error = 'Logo Rest Hatasıi Lütfen Sistem Yöneticisi İle İrtibata Geçiniz.';
        } else {
            return $this->TalepKarsila($this->talep_id);
        }
    }

    public function render()
    {
        return view('livewire.malzemeler.talep-karsila');
    }


    public function updatingKarsila($val, $key)
    {
        // dd($key);
    }

    public function foto_goster($id)
    {
        $this->item_id = $id;
        $this->item = LogoItems::find($id);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $id)->get();
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#MalzemeFotoModal']);
    }
}
