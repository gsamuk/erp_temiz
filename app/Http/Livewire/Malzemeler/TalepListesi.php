<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\LogoDemand; /// Malzeme Talep Listesi
use App\Http\Controllers\LogoRest;
use App\Models\Demand;
use App\Models\LogoItemsPhoto;
use App\Models\LogoItems;
use DB;

class TalepListesi extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $status = 10;
    public $item;
    public $item_id;
    public $item_photos;

    protected $listeners = ['TalepSil' => 'TalepSil'];

    public function set_status($status)
    {
        $this->status = $status;
    }


    function TalepSil($data)
    {
        //
    }


    public function render()
    {

        if ($this->status == 10) {

            $data = Demand::Where('demand.description', 'like', '%' . $this->search . '%')
                ->OrWhere('demand.demand_no', 'like', '%' . $this->search . '%')
                ->leftjoin('lv_items', 'demand.logo_stockref', '=', 'lv_items.logicalref')
                ->leftjoin('company', 'demand.company_id', '=', 'company.id')
                ->leftjoin('users', 'demand.users_id', '=', 'users.id')
                ->select(
                    'users.name',
                    'company.company_name',
                    'lv_items.stock_name',
                    'demand.*',
                )
                ->orderBy('demand.id', 'desc')
                ->paginate(15);
        } else {

            $data = Demand::Where('demand.status', $this->status)
                ->leftjoin('lv_items', 'demand.logo_stockref', '=', 'lv_items.logicalref')
                ->leftjoin('company', 'demand.company_id', '=', 'company.id')
                ->leftjoin('users', 'demand.users_id', '=', 'users.id')
                ->select(
                    'users.name',
                    'company.company_name',
                    'lv_items.stock_name',
                    'demand.*',
                )
                ->orderBy('demand.id', 'desc')
                ->paginate(15);
        }

        //dd($data);

        return view('livewire.malzemeler.talep-listesi', [
            'data' => $data
        ]);
    }


    public function goster($id)
    {
        $this->item_id = $id;
        $this->item = LogoItems::find($id);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $id)->get();
        $this->dispatchBrowserEvent('ShowMalzemeFotoModal');
    }
}
