<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Permissions;
use App\Models\UserPermissions;

class IzinYonetimi extends Component
{
    public $user_id;

    protected $listeners = ['getUserId'];


    public function getUserId($id)
    {
        $this->user_id = $id;
    }


    public function render()
    {
        $permissions = Permissions::orderby('group_name', 'asc')->get();
        return view('livewire.users.izin-yonetimi', ['permissions' => $permissions]);
    }


    public function ekle($id)
    {
        $ekle = new UserPermissions;
        $ekle->user_id = $this->user_id;
        $ekle->permission_id = $id;
        $ekle->insert_time = date('Y-m-d H:i:s');
        $ekle->save();
    }


    public function cikar($id)
    {
        $cikar = UserPermissions::Where('user_id', $this->user_id)->Where('permission_id', $id);
        $cikar->delete();
    }
}
