<?php

namespace App\Http\Livewire\Satinalma;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LogoPurchaseOrders;

class Orders extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function render()
    {
        $data = LogoPurchaseOrders::where('account_name', 'like', '%' . $this->search . '%')
            ->orderBy('logicalref', 'desc')
            ->paginate(10);
        return view('livewire.satinalma.orders', [
            'data' => $data
        ]);
    }
}
