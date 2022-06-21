<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;
use App\Models\DemandDetail;
use App\Models\Demand;
use App\Models\DemandFiche;
use App\Models\LogoItemsPhoto;
use App\Models\LogoItems;
use App\Http\Controllers\LogoRest;


class TalepTransferKarsila extends Component
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


    // talep malzemei miktar edit
    public $edit_line_id;
    public $line_item;
    public $line_item_name;
    public $line_quantity;

    protected $listeners = ['TalepTransferKarsila' => 'TalepTransferKarsila'];

    public function TalepTransferKarsila($id)
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
        $this->TalepTransferKarsila($this->talep_id);

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

        $this->TalepTransferKarsila($this->talep_id);
        $this->emit('LoadDemandList');
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

        $this->TalepTransferKarsila($this->talep_id);
        $this->emit('LoadDemandList');
    }



    public function kaydet_transfer() // sarf içn
    {
        $sarf_items = array();
        $satinal_items = array();
        $logo_po_ref = null;
        $logo_fiche_ref = null;
        $this->error = null;

        // kontroller
        $sarf = false;
        $satinal = false;
        $return_msg = "";


        if ($this->karsila[$this->talep_id]) {
            foreach ($this->karsila[$this->talep_id] as $item_id => $miktar) {
                if ($miktar > 0) {

                    // status kontrolleri
                    $item = DemandDetail::find($item_id);
                    $item->status = 1; // stoktan karşılama
                    $item->save();
                    ///
                    $demand = Demand::find($this->talep_id);

                    $logo_item = LogoItems::find($item->logo_stock_ref);

                    $sarf_items[] = [
                        "ITEM_CODE" => $item->stock_code,
                        "ITEMREF" => $item->logo_stock_ref,
                        "UNIT_CODE" => $item->unit_code,
                        "DESCRIPTION" => $item->description,
                        "PRICE" => $logo_item->average_price,
                        "TYPE" => 25,
                        'QUANTITY' => $miktar,
                        'SOURCEINDEX' =>  $demand->warehouse_no,
                        'DESTINDEX' => $demand->dest_wh_no,
                    ];
                }
            }
        }


        if ($this->satinal[$this->talep_id]) {
            foreach ($this->satinal[$this->talep_id] as $item_id => $miktar) {
                if ($miktar > 0) {

                    // status kontrolleri
                    $item = DemandDetail::find($item_id);
                    if ($item->status == 1) { // eğer stoktan karşılama varsa
                        $item->status = 3;  // hep stok hem satınalma statusu
                    } else {
                        $item->status = 2; // sadece satın alma statusu
                    }
                    $item->save();
                    ///

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
            'GROUP' => 3,
            "SOURCE_WH" => $demand->warehouse_no,
            "SOURCE_COST_GRP" => $demand->warehouse_no,
            "DEST_WH" => $demand->dest_wh_no,
            "DEST_COST_GRP" => $demand->dest_wh_no,
            'DOC_NUMBER' => "TR" . $this->talep_id,
            "TYPE" => 25,
            'IO_TYPE' => 2,
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

            if ($logo_fiche_ref != null && $logo_fiche_ref > 0) {
                $sarf = $logo_fiche_ref;
                $return_msg .= "<br>Ambar Transfer Fişi Oluşturuldu " . $logo_fiche_ref;

                // eğer logo fişi oluştuysa
                $dm = new DemandFiche;
                $dm->demand_id = $this->talep_id;
                $dm->logo_fiche_ref = $logo_fiche_ref;
                $dm->demand_type = 2; // ambar fişi tipi
                $dm->insert_time = date('Y-m-d H:i:s');
                $dm->save();
                // logo sarf fişi başarılı ise fiş kaydı ekleniyor.

                $dm = Demand::find($this->talep_id);
                $dm->status = 1;
                $dm->save();
                // Talep durumu işlem yapıldı (1) olarak set ediliyor.

            } else {
                //eğer logo sarf fişi oluşturamazsa status değerlerini değişir
                // daha önce sarf edildi olan status değerleri değiştiriliyor
                DemandDetail::Where("demand_id", $this->talep_id)->Where("status", 1)->update(["status" => 0]);
                DemandDetail::Where("demand_id", $this->talep_id)->Where("status", 3)->update(["status" => 2]);
                ///
            }
        }

        if (count($satinal_items) > 0) {

            $logo_po_ref  = LogoRest::SiparisOlustur($satinal_data, 0);

            if ($logo_po_ref != null && $logo_po_ref > 0) {
                $satinal = $logo_po_ref;
                $return_msg .= "<br>Satınalma Fişi Oluşturuldu, Fiş No : " . $logo_po_ref;
                // eğer talep malzemelerinde satın alma fişi oluştuysa
                $dm = Demand::find($this->talep_id);
                $dm->logo_po_ref = $logo_po_ref;
                $dm->status = 1;
                $dm->save();
                // Talep durumu işlem yapıldı (1) olarak set ediliyor.

            } else {
                //eğer logo satınalma fişi oluşturamazsa status değerlerini değişir
                // daha önce satınalma yapıldı olan status değerleri değiştiriliyor
                DemandDetail::Where("demand_id", $this->talep_id)->Where("status", 2)->update(["status" => 0]);
                DemandDetail::Where("demand_id", $this->talep_id)->Where("status", 3)->update(["status" => 1]);
            }
        }

        if (!$sarf && !$satinal) {
            $this->error = "Logo Fişleri Oluşturulamadı, Lütfen Firma Seçerek Tekrar Deneyiniz.";
        } else {

            return session()->flash('success', $return_msg);
        }
    }


    public function render()
    {
        return view('livewire.malzemeler.talep-transfer-karsila');
    }


    public function edit_line($id, $name)
    {
        $this->edit_line_id = $id;
        $this->line_item_name = $name;
        $this->line_item = DemandDetail::find($id);
        $this->line_quantity = number_format($this->line_item->quantity, 0, "", "");
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#editLineModal']);
    }

    public function update_line()
    {
        $line =  DemandDetail::find($this->edit_line_id);
        $line->quantity =  $this->line_quantity;
        $line->save();
        $this->dispatchBrowserEvent('CloseModal');
        $this->TalepTransferKarsila($this->talep_id);
    }

    public function foto_goster($id)
    {
        $this->item_id = $id;
        $this->item = LogoItems::find($id);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $id)->get();
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#MalzemeFotoModal']);
    }
}