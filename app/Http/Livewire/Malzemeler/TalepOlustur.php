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

    public $desc;
    public $warehouse = 0;
    public $birim_select = [];
    public $tid = 0; // talep  id
    public $item_photos;


    public $zaman;
    public $demand_desc;



    protected $listeners = ["getItem", "getOzelKod", "getProject"];

    public function mount()
    {
        date_default_timezone_set('Europe/Istanbul');
        $this->zaman = date("2021-m-d");
    }

    public function SetLine($d, $modal)
    {
        $this->line = $d;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => $modal]);
    }

    public function getOzelKod($d)
    {
        $d = json_decode($d);
        $this->special_code = $d->special_code;
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
        $this->desc[$this->line] = "İhtiyaç";
        $this->miktar[$this->line] = 1; // test verisi


        $this->dispatchBrowserEvent('CloseModal');
    }


    public function store()
    {
        $insert_time = date('Y-m-d H:i:s');

        $demand = new Demand;
        $demand->company_id = 1;
        $demand->users_id = Erp::user_id();
        $demand->warehouse_no = $this->warehouse;
        $demand->demand_desc = $this->demand_desc;
        $demand->project_code = $this->project_code;
        $demand->special_code = $this->special_code;
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
