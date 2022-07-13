<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\LogoItems;
use App\Models\LogoItemsPhoto;

use App\Models\DemandDetail;

class TalepMalzemeOnay extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $owner;

    public $item_id; // fotoğraf gösterimi

    public function render()
    {
        $data = DemandDetail::orderBy('demand.id', 'desc')
            ->where('demand_detail.status', 5)
            ->when($this->owner, function ($query) {
                return $query->where('users.name', 'like', '%' . $this->owner . '%');
            })
            ->when($this->search, function ($query) {
                return $query->where('demand_detail.stock_name', 'like', '%' . $this->search . '%');
            })
            ->select(
                "demand_detail.*",
                "demand_detail.id as dt_id",
                "demand_detail.status as dt_status",
                "demand.*",
                "users.photo_path",
                "users.name",
                "users.surname"
            )
            ->join("demand", "demand.id", "=", "demand_detail.demand_id")
            ->join("users", "users.id", "=", "demand.users_id")
            ->paginate(10);

        return view('livewire.malzemeler.talep-malzeme-onay', [
            'data' => $data
        ]);
    }

    public function onay($id, $c, $p)
    {
        $up = DemandDetail::find($id);
        $up->approved_consump = $c;
        $up->approved_purchase = $p;
        $up->status = 6;
        $up->save();
    }


    public function islem($id, $status)
    {
        $up = DemandDetail::find($id);
        $up->status = $status;
        $up->save();
    }


    public function foto_goster($id)
    {
        $this->item_id = $id;
        $this->item = LogoItems::find($id);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $id)->get();
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#MalzemeFotoModal']);
    }

    public function talep_detay($id)
    {
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#TalepDetayModal']);
    }
}