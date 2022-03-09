<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Users;

class UserListTable extends Component
{
    public $name, $surname, $user_name, $password, $email;

    public $users;
    public function render()
    {
        return view('livewire.user-list-table');
    }

    public function mount()
    {
        $this->getAll();
    }


    public function store()
    {
        session()->flash('message', 'Users Created Successfully.');
    }

    public function getAll()
    {
        $user_list = Users::join('Authorizations', 'users.id', '=', 'authorizations.user_id')
            ->select(
                'users.*',
                'authorizations.purchase_view',
                'authorizations.sale_view',
                'authorizations.purchase_approve',
                'authorizations.sale_approve',
                'authorizations.is_admin'
            )
            ->get();
        $this->users = $user_list;
    }
}
