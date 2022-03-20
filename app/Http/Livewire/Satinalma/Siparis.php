<?php

namespace App\Http\Livewire\Satinalma;

use Livewire\Component;
use App\Models\LogoDb;

class Siparis extends Component
{

    public $tip, $kod, $aciklama, $miktar, $birim, $birim_fiyat;
    public $updateMode = false;
    public $inputs = [];
    public $i = 1;

    protected $listeners = ["getItem"];


    public function getItem($d)
    {
        $item = LogoDb::where('LOGICALREF', $d['ref'])->first();
        $this->kod[$d['line']] = $item->CODE;
        $this->aciklama[$d['line']] = $item->NAME;
    }


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


    public function render()
    {
        return view('livewire.satinalma.siparis');
    }
}
