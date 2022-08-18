<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Permissions;
use App\Models\UserPermissions;
use App\Models\UserCompany;
use App\Models\Users;


class IzinYonetimi extends Component
{
    public $user_id;
    public $user;

    public $firma = 1;
    public $depo = "0";

    protected $listeners = ['getUserId'];


    public function getUserId($id)
    {
        $this->user_id = $id;
        $this->user = Users::find($id);
    }

    public function updatedFirma($id)
    {
        $this->firma = $id;
    }

    public function updatedDepo($id)
    {
        $this->depo = $id;
    }

    public function render()
    {
        $permissions = Permissions::orderby('group_name', 'asc')->get();
        $user_company = UserCompany::Where('user_id', $this->user_id)->get();

        return view('livewire.users.izin-yonetimi', ['permissions' => $permissions, 'user_company' => $user_company]);
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

    public function depo_izin_cikar($id)
    {
        $cikar = UserCompany::Where('user_id', $this->user_id)->Where('id', $id);
        $cikar->delete();
    }

    public function depo_izin_ekle()
    {
        $ekle = new UserCompany();
        $ekle->user_id = $this->user_id;
        $ekle->company_id = $this->firma;
        $ekle->warehouse_no = $this->depo;
        $ekle->insert_time = date('Y-m-d H:i:s');
        $ekle->save();
    }
}