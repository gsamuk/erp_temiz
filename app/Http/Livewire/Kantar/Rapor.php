<?php

namespace App\Http\Livewire\Kantar;

use Livewire\Component;
use App\Models\KantarData;
use Illuminate\Support\Facades\DB;


class Rapor extends Component
{
    public $data;
    public $cari;
    public $tarih;
    public $kantar = 1;


    protected $listeners = ['SetReport', 'Yenile' => '$refresh'];

    public function updatedTarih($val)
    {
        $this->tarih = $val;
    }


    public function render()
    {
        return view(
            'livewire.kantar.rapor'
        );
    }


    public function rapor_uret()
    {
        if (!$this->tarih) {
            return session()->flash('error', 'Lütfen Tarih Seçiniz...');
        }
        DB::enableQueryLog();

        $this->cari = KantarData::whereDate('tarti_cikis_zaman', $this->tarih)
            ->when(($this->kantar == 1), function ($query) {
                return $query->where('kantar_id', 2)->Orwhere('kantar_id', 3);
            })->when(($this->kantar == 2), function ($query) {
                return $query->where('kantar_id', 1)->Orwhere('kantar_id', 4);
            })->select('firma_kod')->distinct()->get();
        //dd(DB::getQueryLog());
    }
}