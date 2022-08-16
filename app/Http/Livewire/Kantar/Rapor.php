<?php

namespace App\Http\Livewire\Kantar;

use Livewire\Component;
use App\Models\KantarData;
use Illuminate\Support\Facades\DB;


class Rapor extends Component
{

    public $file_id;
    protected $listeners = ['SetReport', 'Yenile' => '$refresh'];


    public function render()
    {
        $data =   KantarData::Where('file_id', $this->file_id)->get();

        $firmalar =  DB::select('
        select distinct(firma_kod),
        (select TOP 1 firma from kantar_data AS SKD Where SKD.firma_kod = KD.firma_kod) as firma
        FROM kantar_data as KD
        Where KD.file_id = ?        
        ', [$this->file_id]);

        $malzemeler =  DB::select('
        select distinct(malzeme_sku),
        (select TOP 1 malzeme from kantar_data AS SKD Where SKD.malzeme_sku = KD.malzeme_sku) as malzeme
        FROM kantar_data as KD
        Where KD.file_id = ?        
        ', [$this->file_id]);

        return view(
            'livewire.kantar.rapor',
            [
                'data' => $data,
                'firmalar' => $firmalar,
                'malzemeler' => $malzemeler
            ]
        );
    }


    public function SetReport($id)
    {
        $this->file_id = $id;
    }
}