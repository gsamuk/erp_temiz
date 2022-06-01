<?php

namespace App\Http\Livewire\Users;


use Livewire\Component;
use App\Models\Users;

class Liste extends Component
{
    public $user;
    public $user_id;

    public function render()
    {
        $data = Users::all();
        return view('livewire.users.liste', ['data' => $data]);
    }



    public function getUser($id)
    {
        $this->user_id = $id;
        $this->user = Users::find($id);
    }
}
