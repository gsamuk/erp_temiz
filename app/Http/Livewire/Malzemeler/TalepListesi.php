<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\LogoDemand; /// Malzeme Talep Listesi
use App\Http\Controllers\LogoRest;
use DB;

class TalepListesi extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $fichne_status = 'all';

    protected $listeners = ['TalepSil' => 'TalepSil'];

    public function set_status($status)
    {
        $this->fichne_status = $status;
    }


    function TalepSil($data)
    {
        LogoRest::MalzemeTalepSil($data);
    }


    public function render()
    {
        DB::enableQueryLog();
        if ($this->fichne_status == "all") {

            $data = LogoDemand::Where('special_code', 'like', '%' . $this->search . '%')
                ->OrWhere('fiche_no', 'like', '%' . $this->search . '%')
                ->orderBy('fichne_status', 'asc')
                ->paginate(10);
        } else {

            $data = LogoDemand::Where('fichne_status', $this->fichne_status)
                ->orderBy('fichne_status', 'asc')
                ->paginate(10);
        }



        return view('livewire.malzemeler.talep-listesi', [
            'data' => $data
        ]);
    }


    public function goster($id)
    {
        dd($id);
    }
}
