<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Users;
use App\Models\Authorizations;

class UserListTable extends Component
{
    public $name, $surname, $user_name, $password, $email, $logo_user, $logo_password;
    public $users;

    protected $rules = [
        'name' => 'required',
        'surname' => 'required',
        'user_name' => 'required|unique:users',
        'password' => 'required',
        'email' => 'required|email|unique:users',
    ];

    protected $messages = [
        'name.required' => 'Ad Giriniz',
        'surname.required' => 'Soyad Giriniz',
        'user_name.required' => 'Kullanıcı adı giriniz',
        'user_name.unique' => 'Bu kullanıcı adı kullanılıyor',
        'password.required' => 'Kullanıcı Şifresi giriniz',
        'email.required' => 'Email Adresi Giriniz',
        'email.email' => 'E-mail Adresi Geçersiz',
        'email.unique' => 'E-mail Adresi Kullanılıyor',
    ];


    public function render()
    {
        return view('livewire.user.user-list-table');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->getAll();
    }


    public function store()
    {
        $validatedData = $this->validate();
        $user = Users::create($validatedData);

        $aut = new Authorizations;
        $aut->user_id = $user->id;
        $aut->save();

        session()->flash('message', 'Users Created Successfully.');
        return redirect()->to('/users')->with('message', 'Kullanıcı Eklendi');
    }


    public function remove($id)
    {
        $user = Users::find($id);
        $user->delete();

        $aut = Authorizations::Where('user_id', $id);
        $aut->delete();
        return redirect()->to('/users')->with('message', 'Kullanıcı Silindi');
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
