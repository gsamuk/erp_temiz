<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;
use App\Models\DemandDetail;
use App\Models\Demand;
use App\Models\LogoItemsPhoto;
use App\Models\LogoItems;

class TalepKarsila extends Component
{
    public $talep_detay;
    public $talep_id;

    public $talep_line;


    public $karsila;
    public $satinal;

    public $item;
    public $item_id;
    public $item_photos;


    protected $listeners = ['TalepKarsila' => 'TalepKarsila'];

    public function TalepKarsila($id)
    {
        $this->talep_id = $id;
        $this->talep_detay = DemandDetail::Where('demand_id', $id)->get();
    }


    public function render()
    {
        return view('livewire.malzemeler.talep-karsila');
    }


    public function foto_goster($id)
    {
        $this->item_id = $id;
        $this->item = LogoItems::find($id);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $id)->get();
        $this->dispatchBrowserEvent('ShowMalzemeFotoModal');
    }
}
