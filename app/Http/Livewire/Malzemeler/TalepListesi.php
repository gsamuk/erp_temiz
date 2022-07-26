<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Demand;


class TalepListesi extends Component
{
    protected $listeners = ['LoadDemandList' => '$refresh', 'RefreshTalepListesi' => '$refresh', 'IslemDetay'];

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user_search;
    public $talep_id; // talep no


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
            ->when($this->talep_id, function ($query) {
                return $query->where('demand.id', $this->talep_id);
            })
            ->when($this->user_search, function ($query) {
                return $query->where('users.name', 'like', '%' . $this->user_search . '%')
                    ->Orwhere('users.surname', 'like', '%' . $this->user_search . '%');
            })
            ->when(($this->status == 1), function ($query) {
                return $query->where('demand.status', $this->status);
            })
            ->when(($this->status == 0), function ($query) {
                return $query->where('demand.status', $this->status);
            })
            ->when(($this->status == 2), function ($query) {
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
            ->paginate(8);

        return view('livewire.malzemeler.talep-listesi', [
            'data' => $data
        ]);
    }





    public function id_reset($id)
    {
        $this->talep_satir_id = $id;
        $this->talep_islem_id = null;
        $this->talep_detay_id = null;
        $this->emit('SetDemandId', $id);
    }

    // sarf
    public function talep_detay($id)
    {
        $this->id_reset($id);
        $this->talep_detay_id = $id;
        $this->emit('TalepKarsila', $id);
    }


    public function IslemDetay($id)
    {
        $this->id_reset($id);
        $this->talep_islem_id = $id;
        $this->emit('TalepIslem', $id);
    }

    public  function talep_islem_detay($id)
    {
        $this->id_reset($id);
        $this->talep_islem_id = $id;
        $this->emit('TalepIslem', $id);
    }


    public function set_username($n)
    {
        $this->user_search = $n;
    }
}