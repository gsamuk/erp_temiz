<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;
use App\Models\DemandDetail;
use App\Models\Demand;
use App\Models\DemandFiche;
use App\Models\LogoItemsPhoto;
use App\Models\LogoItems;
use App\Http\Controllers\LogoRest;
use App\Models\IncompletedDemand;


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

    // TESt
    public $konay; // karşılama miktar onayı
    public $sonay; // satın alma miktar onayı

    // talep malzemei miktar edit
    public $edit_line_id;
    public $line_item;
    public $line_item_name;
    public $line_quantity;

    // satınalma firması seç
    public $stock_code;
    public $s_item_id; // satın alma firması set edilecek item id


    protected $listeners = ['TalepKarsila' => 'TalepKarsila', 'getAccount' => 'getAccount', 'RefreshTalepKarsila' => '$refresh'];

    public function TalepKarsila($id)
    {
        $this->error = null;
        $this->talep_id = $id;
        $this->talep = Demand::find($id);
        $this->talep_detay = DemandDetail::Where('demand_id', $id)->Where('status', '!=', 9)->get();
        if (isset($this->talep_detay)) {
            if ($this->talep_detay->count() == 0) {
                $this->talep_detay = null;
            }
            if ($this->talep_detay->count() > 0) {
                foreach ($this->talep_detay as $t) {
                    $this->konay[$t->id] = number_format($t->approved_consump, 0, ',', '.');
                    $this->sonay[$t->id] = number_format($t->approved_purchase, 0, ',', '.');
                }
            }
        }
    }

    public function updatedKonay($value, $id) // karşılama miktarı onayı trigger when updated
    {
        $d = DemandDetail::find($id);
        $d->approved_consump = $value;
        $d->save();
    }

    public function updatedSonay($value, $id) // satın alma miktarı onayı trigger when updated
    {
        $d = DemandDetail::find($id);
        $d->approved_purchase = $value;
        $d->save();
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
        $up->approved_consump = null;
        $up->approved_purchase = null;
        $up->cancel_reason = $this->iptal_sebep;
        $up->save();

        $count = DemandDetail::Where('demand_id', $this->talep_id)->Where('status', '!=', 9)->count();

        if ($count == 0) {
            $up = Demand::find($this->talep_id);
            $up->status = 9;
            $up->save();
            $this->talep_detay = null;
            $this->emit('RefreshTalepListesi');
            $this->dispatchBrowserEvent('CloseModal');
        }

        if ($count > 0) {
            $this->dispatchBrowserEvent('CloseModal');
            $this->TalepKarsila($this->talep_id);
        }
    }

    public function unapproved()
    {
        $dm = Demand::find($this->talep_id);
        $dm->approved = 0;
        $dm->save();
        $this->konay = null;
        $this->sonay = null;
        $this->emit('RefreshTalepListesi');
        $this->TalepKarsila($this->talep_id);
    }

    public function approved()
    {
        $dm = Demand::find($this->talep_id);
        $dm->approved = 1;
        $dm->save();
        $this->emit('RefreshTalepListesi');
        $this->TalepKarsila($this->talep_id);
    }


    public function _kaydet() // sarf içn
    {

        dd(DemandDetail::distinct()->Where('demand_id', $this->talep_id)->whereNotNull('account_code')->get(['account_code']));
        $sarf_items = array();
        $satinal_items = array();
        $logo_po_ref = null;
        $logo_fiche_ref = null;
        $this->error = null;

        // kontroller
        $sarf = false;
        $satinal = false;
        $return_msg = "";

        $onayli_sarf = DemandDetail::Where('demand_id', $this->talep_id)->Where('approved_consump', '>', '0')
            ->get();
        if ($onayli_sarf->count() > 0) {
            foreach ($onayli_sarf as $item) {

                $_item = DemandDetail::find($item->id);
                $_item->status = 1; // stoktan karşılama
                $_item->save();

                $logo_item = LogoItems::find($item->logo_stock_ref);
                $sarf_items[] = [
                    "ITEM_CODE" => $item->stock_code,
                    "ITEMREF" => $item->logo_stock_ref,
                    "UNIT_CODE" => $item->unit_code,
                    "DESCRIPTION" => $item->description,
                    "PRICE" => $logo_item->average_price,
                    "TYPE" => 25,
                    'QUANTITY' => $item->approved_consump,
                ];
            }
        }


        $onayli_satinal = DemandDetail::Where('demand_id', $this->talep_id)->Where('approved_purchase', '>', '0')
            ->get();

        if ($onayli_satinal->count() > 0) {
            foreach ($onayli_satinal as $item) {
                // status kontrolleri
                $_item = DemandDetail::find($item->id);
                if ($_item->status == 1) { // eğer stoktan karşılama varsa
                    $_item->status = 3;  // hep stok hem satınalma statusu
                } else {
                    $_item->status = 2; // sadece satın alma statusu
                }
                $_item->save();
                ///

                $satinal_items[] = [
                    "STOCKREF" => $item->logo_stock_ref,
                    "UNIT_CODE" => $item->unit_code,
                    "TYPE" => 0,
                    'QUANTITY' => $item->approved_purchase,
                ];
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

            if ($logo_fiche_ref != null && $logo_fiche_ref > 0) {
                $sarf = $logo_fiche_ref;
                $return_msg .= " > Sarf Fişi Oluşturuldu " . $logo_fiche_ref;

                // eğer logo fişi oluştuysa
                $dm = new DemandFiche;
                $dm->demand_id = $this->talep_id;
                $dm->logo_fiche_ref = $logo_fiche_ref;
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
                $return_msg .= " > Satınalma Fişi Oluşturuldu, Fiş No : " . $logo_po_ref;
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


            $kalan = IncompletedDemand::where('demand_id', $this->talep_id)->count();
            if ($kalan == 0) {
                $d = Demand::find($this->talep_id);
                $d->status = 2;
                $d->save();
            }

            $this->emit('RefreshTalepListesi');
            $this->emit('RefreshTalepKarsila');
            return session()->flash('success', $return_msg);
        }
    }



    public function render()
    {
        return view('livewire.malzemeler.talep-karsila');
    }


    public function kaydet()
    {
        $demand = Demand::find($this->talep_id);
        $sarf = $this->sarfet($demand);

        $satinal = false;
        $cari = DemandDetail::distinct()
            ->Where('demand_id', $this->talep_id)
            ->Where('approved_purchase', '>', 0)
            ->get(['account_code']);

        if ($cari->count() > 0) {
            foreach ($cari as $d) {
                $satinal = $this->satinal($demand, $d->account_code);
            }
        }

        if ($sarf || $satinal) {

            $up = Demand::find($this->talep_id);
            $up->status = 1;
            $up->save();
            $this->emit('RefreshTalepListesi');
        }
    }




    public function sarfet($demand)
    {
        $rest_items = array();
        $sarf = DemandDetail::Where('demand_id', $this->talep_id)
            ->Where('approved_consump', '>', '0')
            ->get();

        if ($sarf->count() > 0) {
            foreach ($sarf as $item) {
                $logo_item = LogoItems::find($item->logo_stock_ref);
                $rest_items[] = [
                    "ITEM_CODE" => $item->stock_code,
                    "ITEMREF" => $item->logo_stock_ref,
                    "UNIT_CODE" => $item->unit_code,
                    "DESCRIPTION" => $item->description,
                    "PRICE" => $logo_item->average_price,
                    "TYPE" => 25,
                    'QUANTITY' => $item->approved_consump,
                ];
            }
        }


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
                'items' => $rest_items
            ]
        ];

        $ref  = LogoRest::SarfFisiOlustur($sarf_data, 0);
        if ($ref != null && $ref > 0) {
            $insert = new DemandFiche;
            $insert->demand_id = $this->talep_id;
            $insert->demand_type = $demand->demand_type;
            $insert->logo_fiche_ref = $ref;
            $insert->fiche_type = 1; // sarf fişi
            $insert->insert_time = date('Y-m-d H:i:s');
            $insert->save();
            return $ref;
        } else {
            return false;
        }
    }

    public function satinal($demand, $account_code)
    {
        $rest_items = array();

        // verilen cariye set edilmiş, onaylı satınalma malzemelerini getiriyoruz
        $items = DemandDetail::Where('demand_id', $this->talep_id)
            ->Where('approved_purchase', '>', 0)
            ->where('account_code', $account_code)
            ->get();

        foreach ($items as $item) {
            $rest_items[] = [
                "STOCKREF" => $item->logo_stock_ref,
                "UNIT_CODE" => $item->unit_code,
                "TYPE" => 0,
                'QUANTITY' => $item->approved_purchase,
            ];
        }

        $satinal_data = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'DATE' => "2021-05-21 10:10:00",
            'DOC_NUMBER' => "TLP" . $this->talep_id,
            'CLIENTREF' => 7,
            'ARP_CODE' => $account_code,
            "TYPE" => 2,
            'SOURCE_WH' => $demand->warehouse_no,
            'TRANSACTIONS' => [
                'items' => $rest_items
            ]
        ];
        $ref  = LogoRest::SiparisOlustur($satinal_data, 0);
        if ($ref != null && $ref > 0) {
            $insert = new DemandFiche;
            $insert->demand_id = $this->talep_id;
            $insert->demand_type = $demand->demand_type;
            $insert->logo_fiche_ref = $ref;
            $insert->fiche_type = 2; // satınalam fişi
            $insert->insert_time = date('Y-m-d H:i:s');
            $insert->save();
            return $ref;
        } else {
            return false;
        }
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
        $this->TalepKarsila($this->talep_id);
    }

    public function foto_goster($id)
    {
        $this->item_id = $id;
        $this->item = LogoItems::find($id);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $id)->get();
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#MalzemeFotoModal']);
    }

    public function firma_sec($item_id, $stock_code)
    {
        $this->s_item_id = $item_id;
        $this->stock_code = $stock_code;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#FirmaSecModal']);
    }

    public function getAccount($data)
    {

        $data = json_decode($data);
        $up =  DemandDetail::find($this->s_item_id);
        $up->account_ref =  $data->ref_id;
        $up->account_name =  $data->account_name;
        $up->account_code =  $data->account_code;
        $up->save();
        $this->TalepKarsila($this->talep_id);
        $this->dispatchBrowserEvent('CloseModal');
    }
}