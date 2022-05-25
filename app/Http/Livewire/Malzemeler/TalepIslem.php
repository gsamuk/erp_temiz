<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;
use App\Models\Demand;
use App\Models\DemandDetail;
use App\Models\LogoItems;
use App\Models\LogoItemsPhoto;
use App\Models\LogoConsumpFiche;
use App\Models\LogoConsumpFicheDetail;

class TalepIslem extends Component
{
    public $error;
    public $talep;
    public $talep_id;
    public $talep_detay;


    public $item;
    public $item_id;
    public $item_photos;
    public $uyari = false;

    protected $listeners = ['TalepIslem'];

    public function TalepIslem($id)
    {
        $this->error = null;
        $this->talep_id = $id;
        $this->talep = Demand::find($id);
        $this->talep_detay = DemandDetail::Where('demand_id', $id)->Where('status', '!=', 9)->get();
        if ($this->talep_detay->count() == 0) {
            $this->talep_detay = null;
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
        $this->dispatchBrowserEvent('ShowMalzemeFotoModal');
    }
}
