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
        if ($this->talep_detay->count() == 0) {
            $this->talep_detay = null;
        }
    }

    public function cikar($id)
    {
        DemandDetail::Where('id', $id)->delete();
        $count = DemandDetail::where('demand_id', $this->talep_id)->count();
        if ($count == 0) {
            Demand::Where('id', $this->talep_id)->delete();
            $this->talep_detay = null;
            $this->karsila = null;
            $this->satinal = null;
        } else {
            unset($this->karsila[$this->talep_id][$id]);
            unset($this->satinal[$this->talep_id][$id]);
            $this->TalepKarsila($this->talep_id);
        }
    }

    public function kaydet()
    {
        dd($this->karsila);
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
