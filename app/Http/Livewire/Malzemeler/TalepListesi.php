<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Demand;


class TalepListesi extends Component
{
    protected $listeners = ['LoadDemandList' => '$refresh'];

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user_search;
    public $no_search;
    public $warehouse_search;

    public $status = 99; // hepsi gelir

    public $talep_satir_id;
    public $talep_detay_id;
    public $talep_islem_id;


    public function set_status($status)
    {
        $this->talep_username = null;
        $this->talep_detay_id = null;
        $this->talep_detay = null;
        $this->status = $status;
    }


    public function render()
    {
        $data = Demand::orderBy('demand.id', 'desc')
            ->when($this->no_search, function ($query) {
                return $query->where('demand.id', $this->no_search);
            })
            ->when($this->user_search, function ($query) {
                return $query->where('users.user_name', $this->user_search);
            })
            ->when(($this->status == 1), function ($query) {
                return $query->where('demand.status', $this->status);
            })
            ->when(($this->status == 0), function ($query) {
                return $query->where('demand.status', $this->status);
            })
            ->when(($this->status == 9), function ($query) {
                return $query->where('demand.status', $this->status);
            })

            ->leftjoin('users', 'demand.users_id', '=', 'users.id')
            ->leftjoin('company', 'demand.company_id', '=', 'company.id')
            ->select(
                'users.user_name',
                'users.name',
                'users.surname',
                'company.company_name',
                'demand.*',
            )
            ->paginate(15);

        return view('livewire.malzemeler.talep-listesi', [
            'data' => $data
        ]);
    }



    public  function talep_detay($id)
    {
        $this->talep_islem_id = null;
        $this->talep_satir_id = $id; // seçili satırı renklendirme için
        $this->talep_detay_id = $id;
        $this->emit('TalepKarsila', $id);
    }


    public  function talep_islem_detay($id)
    {
        $this->talep_detay_id = null;
        $this->talep_satir_id = $id; // seçili satırı renklendirme için
        $this->talep_islem_id = $id;
        $this->emit('TalepIslem', $id);
    }


    public function set_username($n)
    {
        $this->user_search = $n;
    }
}