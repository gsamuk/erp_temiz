<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\WithPagination;
use Livewire\Component;

use App\Models\Demand;
use App\Models\DemandDetail;
use App\Models\LogoItemsPhoto;
use App\Models\LogoItems;
use DB;

class TalepListesi extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user_search;
    public $no_search;
    public $warehouse_search;



    public $status = 10; // hepsi gelir

    public $item;
    public $item_id;
    public $item_photos;


    public $talep_username;
    public $talep_detay_id;
    public $talep_detay;


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

            ->leftjoin('users', 'demand.users_id', '=', 'users.id')
            ->leftjoin('company', 'demand.company_id', '=', 'company.id')
            ->select(
                'users.user_name',
                'company.company_name',
                'demand.*',
            )
            ->paginate(15);

        return view('livewire.malzemeler.talep-listesi', [
            'data' => $data
        ]);
    }



    public  function talep_detay($id, $name)
    {
        $this->talep_username = $name;
        $this->talep_detay_id = $id; // seçili satırı renklendirme için

        $this->emit('TalepYenile', $id);

        $this->talep_detay = DemandDetail::Where('demand_detail.demand_id', $id)
            ->leftjoin('lv_items', 'demand_detail.logo_stock_ref', '=', 'lv_items.logicalref')
            ->select(
                'lv_items.logicalref',
                'lv_items.stock_code',
                'lv_items.stock_name',
                'lv_items.onhand_quantity',
                'demand_detail.*',
            )->get();
    }


    public function set_username($n)
    {
        $this->user_search = $n;
    }
}
