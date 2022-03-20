<?php

namespace App\Http\Livewire\Satinalma;

use Livewire\Component;

class Siparis extends Component
{

    public $tip, $kod, $aciklama, $miktar, $birim, $birim_fiyat;
    public $updateMode = false;
    public $inputs = [];
    public $i = 1;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function setLine($id)
    {

        $this->emitTo("Index", "activeLine");
    }


    public function render()
    {
        return view('livewire.satinalma.siparis');
    }
}
