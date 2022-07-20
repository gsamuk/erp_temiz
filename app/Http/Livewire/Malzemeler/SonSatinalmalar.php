<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;

class SonSatinalmalar extends Component
{
    public $itemref;


    protected $listeners = ['SetRef'];

    public function SetRef($ref)
    {
        $this->itemref = $ref;
    }

    public function render()
    {
        return view('livewire.malzemeler.son-satinalmalar');
    }
}