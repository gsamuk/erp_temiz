<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;
use App\Models\LogoItems;
use Algolia\AlgoliaSearch\SearchIndex;

class Ekle extends Component
{
    public $malzeme;
    public $bul;

    public function render()
    {
        return view('livewire.malzemeler.ekle');
    }

    public function updatingMalzeme($val)
    {
        if ($val) {
            $bul = LogoItems::search($val)->raw();


            $this->bul = $bul;
        } else {
            $this->bul = null;
        }
    }
}