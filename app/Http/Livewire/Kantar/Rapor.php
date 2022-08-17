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

        return view(
            'livewire.kantar.rapor'
        );
    }


    public function SetReport($id)
    {
        $this->file_id = $id;
    }
}