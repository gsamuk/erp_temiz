<?php

namespace App\Http\Livewire\Satinalma;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LogoPurchaseOrders;

class Siparis extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $po_status;
    public $title;

    public function render()
    {
        $data = LogoPurchaseOrders::Where('po_status', $this->po_status)->where('account_name', 'like', '%' . $this->search . '%')
            ->orderBy('logicalref', 'desc')
            ->paginate(5);
        return view('livewire.satinalma.siparis', [
            'data' => $data
        ]);
    }
}
