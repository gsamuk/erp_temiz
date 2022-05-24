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

class TalepOlustur extends Component
{
    public $line = 0;
    public $i = 0;
    public $inputs = [];
    public $ref;
    public $kod;
    public $ozelkod;
    public $aciklama;
    public $miktar;
    public $birim;
    public $project_ref_id;
    public $project_code;
    public $desc;
    public $warehouse;
    public $birim_select = [];
    public $tid = 0; // talep  id
    public $item_photos;


    public $zaman;
    public $belge_no;



    protected $listeners = ["getItem", "getProject"];

    public function getProject($d) // seçilen projeyi  dinleyerek set ediyoruz 
    {
        $this->project_code = $d['code'];
        $this->project_ref_id = $d['ref_id'];
        $this->dispatchBrowserEvent('CloseModal');
    }


    public function mount()
    {

        if ($this->tid > 0) {
            $data = DbController::getTalep($this->tid);
            $items = DbController::getTalepDetay($this->tid);
            foreach ($items as $itm => $v) {
                $this->i = $itm;
                $this->inputs[] = $itm;
                $this->aciklama[$itm] = $v->stock_name;
                $this->kod[$itm] = $v->stock_code;
                $this->miktar[$itm] = $v->quantity;
                $this->desc[$itm] = $v->description;

                $ml = LogoDb::where('stock_code', $v->stock_code)->first();
                $this->ref[$itm] = $ml->logicalref;

                $units = LogoUnits::Where('unitset_ref', $ml->unitset_ref)->get();
                $this->birim_select[$itm] = $units;
                $this->birim[$itm] = $v->unit_code;
            }
        }
    }

    public function render()
    {
        $data = LogoWarehouses::where('company_no', '1')->get();
        return view(
            'livewire.malzemeler.talep-olustur',
            [
                'warehouses' => $data,
            ]
        );
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
        unset($this->item_photos[$v]);
    }



    public function getItem($d) // seçilen malzemeyi  dinleyerek set ediyoruz 
    {

        $this->line = $d["line"];
        $item = LogoDb::where('logicalref', $d['ref'])->first();
        $photos = LogoItemsPhoto::where('logo_stockref', $d['ref'])->first();
        if ($photos) {
            $this->item_photos[$this->line] = $photos;
        }

        $units = LogoUnits::Where('unitset_ref', $item->unitset_ref)->get();
        $this->birim_select[$this->line] = $units;
        $this->birim[$this->line] = $units[0]['unit_code'];

        $this->ref[$this->line] = $item->logicalref;
        $this->kod[$this->line] = $item->stock_code;
        $this->aciklama[$this->line] = $item->stock_name;
        $this->desc[$this->line] = "İhtiyaç";
        $this->miktar[$this->line] = 1; // test verisi


        $this->dispatchBrowserEvent('CloseModal');
    }


    public function store()
    {
        $insert_time = date('Y-m-d H:i:s');

        $demand = new Demand;
        $demand->company_id = 1;
        $demand->users_id = 1;
        $demand->warehouse_no = 1;
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
            $dm->description = $this->desc[$in];
            $dm->insert_time = $insert_time;
            $dm->update_time = $insert_time;
            $dm->save();
        }

        $this->reset();
        return session()->flash('success', $demand_no . ' Belege Numaralı Malzeme Talebi Oluşturuldu.');
    }
}
