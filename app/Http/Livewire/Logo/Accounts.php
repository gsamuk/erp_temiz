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

    public function addAccount($code, $name)
    {
        $this->emit('getAccount', ['code' => $code, 'name' => $name]);
    }

    public function render()
    {
        $data = LogoAccounts::where('account_name', 'like', '%' . $this->search . '%')
            ->orderByDesc('account_name')
            ->paginate(10);

        return view('livewire.logo.accounts', [
            'accounts' => $data,
        ]);
    }
}