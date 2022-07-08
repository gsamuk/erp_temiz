<?php

namespace App\Http\Livewire\Logo;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LogoAccounts;

class Accounts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $item_ref;
    public $item_name;
    public $last_purchase;

    protected $listeners = ['SetItemRef'];


    public function SetItemRef($item)
    {
        $this->item_ref = $item['item_ref'];
        $this->item_name = $item['item_name'];
    }


    public function render()
    {
        $data = LogoAccounts::where('account_name', 'like', '%' . $this->search . '%')
            ->orderByDesc('account_name')
            ->paginate(5);

        return view('livewire.logo.accounts', [
            'accounts' => $data,
            'item_ref' => $this->item_ref,
        ]);
    }
}