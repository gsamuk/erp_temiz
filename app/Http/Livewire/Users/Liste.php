<?php

namespace App\Http\Livewire\Users;


use Livewire\Component;
use App\Models\Users;


class Liste extends Component
{
    public $user;
    public $user_id;
    public $create = false;

    public $confirm_delete;

    // for create and update
    public $name;
    public $surname;
    public $user_name;
    public $password;
    public $email;
    public $logo_user;
    public $logo_password;


    protected $rules = [
        'name' => 'required',
        'surname' => 'required',
        'user_name' => 'required|unique:users',
        'password' => 'required',
        'email' => 'required|email|unique:users',
    ];
    protected $messages = [
        'name.required' => 'Lütfen Ad Giriniz.',
        'surname.required' => 'Lütfen Soyad Giriniz.',
        'user_name.required' => 'Lütfen Kullanıcı Adı Giriniz.',
        'user_name.unique' => 'Bu kullanıcı adı kullanılıyor',
        'password.required' => 'Lütfen Şifre Giriniz.',
        'email.email' => 'Geçersiz Email Adresi',
        'email.unique' => 'E-mail Adresi Kullanılıyor',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function render()
    {
        $data = Users::all();
        return view('livewire.users.liste', ['data' => $data]);
    }


    public function createUserForm()
    {
        $this->reset();
        $this->create = true;
    }


    public function updateUserForm($id)
    {
        $this->create = false;
        $this->user_id = $id;
        $this->user = Users::find($id);
        $this->emit('getUserId', $id);
    }

    public function store()
    {
        $this->validate();
        $user = Users::find($this->user_id);
        $user->user_name = $this->user_name;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->logo_user = $this->logo_user;
        $user->logo_password = $this->logo_password;
        $user->update_time = date('Y-m-d H:i:s');
        $user->save();
        session()->flash('store_message', 'Güncelleme Başarılı...');
    }


    public function create()
    {
        $this->validate();
        $user = new Users;
        $user->user_name = $this->user_name;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->logo_user = $this->logo_user;
        $user->logo_password = $this->logo_password;
        $user->insert_time = date('Y-m-d H:i:s');
        $user->save();
        $this->reset();
        session()->flash('create_message', 'Kullanıcı Ekleme Başarılı...');
    }

    public function cancelDelete()
    {
        $this->confirm_delete = null;
    }
    public function confirmDelete($id)
    {
        $this->confirm_delete = $id;
    }

    public function deleteUser($id)
    {
        $user = Users::find($id);
        $user->delete();
        $this->reset();
        session()->flash('delete_message', 'Kullanıcı Silindi...');
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
