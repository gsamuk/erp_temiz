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
use App\Models\LogoAccounts;

class TalepKarsila extends Component
{
    public $talep;
    public $talep_detay;
    public $talep_id;
    public $error;
    public $talep_owner = false;
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
    public $item_ref; // malzeme ref id
    public $s_item_id; // satın alma firması set edilecek item id



    protected $listeners = ['TalepKarsila' => 'TalepKarsila', 'getOzelKod' => 'getOzelKod', 'getAccount' => 'getAccount', 'getAccount_' => 'getAccount_', 'RefreshTalepKarsila' => '$refresh'];



    public function TalepKarsila($id)
    {
        $this->error = null;
        $this->item_id = null;
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
        $this->TalepKarsila($this->talep_id);
    }

    public function updatedSonay($value, $id) // satın alma miktarı onayı trigger when updated
    {
        $d = DemandDetail::find($id);
        $d->approved_purchase = $value;
        $d->save();
        $this->TalepKarsila($this->talep_id);
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
        // çıkarma işlemi sonrası sayılıyor
        if ($count == 0) {
            $up = Demand::find($this->talep_id);
            $up->status = 9;
            $up->save();
            $this->talep_detay = null;
            $this->emit('RefreshTalepListesi');
            $this->dispatchBrowserEvent('CloseModal');
        } else {
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

    public function render()
    {
        if ($this->talep_owner) {
            $this->for_manage = false;
        }
        return view('livewire.malzemeler.talep-karsila');
    }


    public function kaydet()
    {

        $demand = Demand::find($this->talep_id);
        $sarf = $this->sarfet($demand);

        // satınalma siparişleri seçilen carilere göre fişleri oluşturuluyor
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
            $kalan = IncompletedDemand::where('demand_id', $this->talep_id)->count();
            $up = Demand::find($this->talep_id);
            if ($kalan == 0) {
                $up->status = 2;
            } else {
                $up->status = 1;
            }
            $up->save();
            $this->emit('RefreshTalepListesi');
            $this->TalepKarsila($this->talep_id);
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

                // çok basit anlaması biraz dikkat
                if ($demand->demand_type == 1) {
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
                // eğer ambar tranferi ise
                if ($demand->demand_type == 2) {
                    $rest_items[] = [
                        "ITEM_CODE" => $item->stock_code,
                        "ITEMREF" => $item->logo_stock_ref,
                        "UNIT_CODE" => $item->unit_code,
                        "DESCRIPTION" => $item->description,
                        "PRICE" => $logo_item->average_price,
                        "TYPE" => 25,
                        'QUANTITY' => $item->approved_consump,
                        'SOURCEINDEX' =>  $demand->warehouse_no,
                        'DESTINDEX' => $demand->dest_wh_no,
                    ];
                }
            }
        }

        // eğer bu talep bir sarf ise
        if ($demand->demand_type == 1) {
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
        }

        // eğer bu talep bir ambar transferi ise
        if ($demand->demand_type == 2) {
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
                    'items' => $rest_items
                ]
            ];
        }


        $ref  = LogoRest::SarfFisiOlustur($sarf_data, 0);
        if ($ref != null && $ref > 0) {
            $insert = new DemandFiche;
            $insert->demand_id = $this->talep_id;
            $insert->demand_type = $demand->demand_type;
            $insert->logo_fiche_ref = $ref;
            $insert->fiche_type = 1; // sarf fişi
            $insert->insert_time = date('Y-m-d H:i:s');
            $insert->save();
            $this->emit('Success', 'Logo Fişi Oluşturuldu');
            return $ref;
        } else {
            $this->emit('Error', 'Logo Fişi Oluşturulamadı');
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
            $this->emit('Success', 'Satınalma Fişi Oluşturuldu');
            return $ref;
        } else {
            $this->emit('Error', 'Satınalma Fişi Oluşturulamadı');
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


    public function firma_iptal($item_id)
    {
        $up = DemandDetail::find($item_id);
        $up->account_ref =  null;
        $up->account_name =  null;
        $up->account_code = null;
        $up->save();
    }

    public function firma_sec($item_id, $item_ref, $item_name)
    {
        $this->emit('SetItemRef', ['item_ref' => $item_ref, 'item_name' => $item_name]);
        $this->s_item_id = $item_id;
        $this->item_ref = $item_ref;
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

    public function getAccount_($account_ref)
    {
        $cari = LogoAccounts::find($account_ref);
        $up =  DemandDetail::find($this->s_item_id);
        $up->account_ref =  $cari->ref_id;
        $up->account_name =  $cari->account_name;
        $up->account_code =  $cari->account_code;
        $up->save();
        $this->TalepKarsila($this->talep_id);
        $this->dispatchBrowserEvent('CloseModal');
    }
}