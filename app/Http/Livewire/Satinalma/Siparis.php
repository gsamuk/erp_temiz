<?php

namespace App\Http\Livewire\Satinalma;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LogoPurchaseOrders;
use App\Http\Controllers\LogoRest;



class Siparis extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $po_status = 0;
    protected $listeners = ['SiparisSil' => 'SiparisSil', 'SiparisStatus' => 'SiparisStatus'];

    function SiparisSil($data)
    {
        LogoRest::SiparisSil($data);
    }

    function SiparisStatus($data)
    {
        LogoRest::SiparisStatus($data);
    }

    public function setPo_status($id)
    {
        $this->po_status = $id;
    }


    public function render()
    {
        if ($this->po_status == 0) {
            $data = LogoPurchaseOrders::where('account_name', 'like', '%' . $this->search . '%')
                ->orderBy('po_status', 'asc')->paginate(30);
        } else {
            $data = LogoPurchaseOrders::Where('po_status', $this->po_status)
                ->where('account_name', 'like', '%' . $this->search . '%')
                ->orderBy('po_status', 'asc')->paginate(30);
        }

        return view('livewire.satinalma.siparis', [
            'data' => $data
        ]);
    }
}
