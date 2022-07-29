<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\LogoItems;
use App\Models\LogoItemsPhoto;

use App\Models\DemandDetail;
use App\Helpers\Erp;
use App\Models\LogoAccounts;

class TalepMalzemeOnay extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $owner;

    public $item_id; // fotoğraf gösterimi

    public $pop_item_id;
    public $pop_item_val;
    public $bilgi_notu;
    /// 
    public $cons;
    public $purc;


    public $s_item_id;
    public $item_ref;

    protected $listeners = ['getAccount' => 'getAccount', 'getAccount_' => 'getAccount_'];


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
        $up->approve_user_id = Erp::user_id();
        $up->approved_purchase = $p;
        $up->approve_time = date('Y-m-d H:i:s');
        $up->status = 6;
        $up->save();
    }


    public function islem($id, $status)
    {
        $up = DemandDetail::find($id);
        $up->status = $status;
        $up->approve_user_id = Erp::user_id();
        $up->approved_consump = 0;
        $up->approved_purchase = 0;
        $up->approve_time = date('Y-m-d H:i:s');
        $up->save();
    }


    public function foto_goster($id)
    {
        $this->item_id = $id;
        $this->item = LogoItems::find($id);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $id)->get();
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#MalzemeFotoModal']);
    }




    public function popup_red($id, $val)
    {
        $this->pop_item_id = $id;
        $this->pop_item_val = $val;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#NotModal']);
    }

    public function popup_onay($id, $cons, $purc, $val)
    {
        $this->pop_item_id = $id;
        $this->pop_item_val = $val;

        $this->cons = $cons;
        $this->purc = $purc;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#NotModal']);
    }


    public function _onay()
    {
        $up = DemandDetail::find($this->pop_item_id);
        $up->status = 6;
        $up->approve_note = $this->bilgi_notu;
        $up->approve_user_id = Erp::user_id();
        $up->approved_consump = $this->cons;
        $up->approved_purchase = $this->purc;
        $up->approve_time = date('Y-m-d H:i:s');
        $up->save();
    }



    public function _red()
    {
        $up = DemandDetail::find($this->pop_item_id);
        $up->status = 7;
        $up->approve_note = $this->bilgi_notu;
        $up->approve_user_id = Erp::user_id();
        $up->approved_consump = 0;
        $up->approved_purchase = 0;
        $up->approve_time = date('Y-m-d H:i:s');
        $up->save();
    }

    public function firma_sec($item_id, $item_ref, $item_name)
    {
        $this->emit('SetItemRef', ['item_ref' => $item_ref, 'item_name' => $item_name]);
        $this->s_item_id = $item_id;
        $this->item_ref = $item_ref;
        $this->dispatchBrowserEvent('OpenModal', ['ModalName' => '#FirmaSecModal']);
    }

    public function getAccount_($account_ref)
    {
        $cari = LogoAccounts::find($account_ref);
        $up =  DemandDetail::find($this->s_item_id);
        $up->account_ref =  $cari->ref_id;
        $up->account_name =  $cari->account_name;
        $up->account_code =  $cari->account_code;
        $up->save();
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function getAccount($data)
    {
        $data = json_decode($data);
        $up =  DemandDetail::find($this->s_item_id);
        $up->account_ref =  $data->ref_id;
        $up->account_name =  $data->account_name;
        $up->account_code =  $data->account_code;
        $up->save();
        $this->dispatchBrowserEvent('CloseModal');
    }
}