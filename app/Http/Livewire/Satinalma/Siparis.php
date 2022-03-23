<?php

namespace App\Http\Livewire\Satinalma;

use Livewire\Component;
use App\Models\LogoDb;

class Siparis extends Component
{

    public $tip, $kod, $aciklama, $miktar, $birim, $birim_fiyat, $kdv, $tutar, $net_tutar;
    public $line = 0;

    public $updateMode = false;
    public $inputs = [];
    public $i = 1;

    protected $listeners = ["getItem"];


    public function getItem($d) // seçilen malzemeyi  dinleyerek set ediyoruz 
    {

        $item = LogoDb::where('logicalref', $d['ref'])->first();
        $this->line = $d["line"];
        $this->kod[$this->line] = $item->stock_code;
        $this->aciklama[$this->line] = $item->stock_name;

        $this->dispatchBrowserEvent('CloseModal');
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

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }


    public function render()
    {
        if (isset($this->miktar[$this->line]) && $this->miktar[$this->line] > 0  && isset($this->birim_fiyat[$this->line]) && $this->birim_fiyat[$this->line] > 0) {
            $this->tutar[$this->line] = $this->miktar[$this->line] * $this->birim_fiyat[$this->line];
            $this->net_tutar[$this->line] = $this->miktar[$this->line] * $this->birim_fiyat[$this->line];
        }


        if (isset($this->miktar[$this->line]) && $this->miktar[$this->line] > 0  && isset($this->birim_fiyat[$this->line]) && $this->birim_fiyat[$this->line] > 0  && isset($this->kdv[$this->line]) && $this->kdv[$this->line] > 0) {
            $kdv = $this->kdv[$this->line];
            $tutar = $this->miktar[$this->line] * $this->birim_fiyat[$this->line];
            $this->net_tutar[$this->line] = $tutar;
            $this->tutar[$this->line] = $tutar + ($tutar * ($kdv / 100));
        }


        if (isset($this->miktar[$this->line]) && $this->miktar[$this->line] == 0  || isset($this->birim_fiyat[$this->line]) && $this->birim_fiyat[$this->line] == 0) {
            $this->tutar[$this->line] = null;
        }

        return view('livewire.satinalma.siparis');
    }
}
