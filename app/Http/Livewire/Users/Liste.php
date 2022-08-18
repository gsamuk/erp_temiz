<?php

namespace App\Http\Livewire\Users;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Users;

use Intervention\Image\Facades\Image;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Liste extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    use WithFileUploads;

    public $search;

    public $user;
    public $user_id;

    public $create_page = false;
    public $update_page = false;
    public $perms_page = false;

    public $confirm_delete;

    // for create and update
    public $name;
    public $surname;
    public $user_name;
    public $password;
    public $email;
    public $user_code;
    public $logo_user;
    public $logo_password;
    public $is_active;

    public $photo;

    protected $rules = [
        'name' => 'required',
        'surname' => 'required',
        'user_name' => 'required|unique:users,user_name',
        'password' => 'required',

    ];

    protected $messages = [
        'name.required' => 'Lütfen Ad Giriniz.',
        'surname.required' => 'Lütfen Soyad Giriniz.',
        'user_name.required' => 'Lütfen Kullanıcı Adı Giriniz.',
        'user_name.unique' => 'Bu kullanıcı adı kullanılıyor',
        'password.required' => 'Lütfen Şifre Giriniz.',

    ];

    public function render()
    {
        $data = Users::Where('id', '>', 0)
            ->when(($this->search), function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%')
                    ->orwhere('surname', 'like', '%' . $this->search . '%')
                    ->orwhere('user_code', 'like', '%' . $this->search . '%');
            })->paginate(8);
        return view('livewire.users.liste', ['data' => $data]);
    }


    public function createUserForm()
    {
        $this->reset();
        $this->resPage();
        $this->create_page = true;
    }

    public function resPage()
    {
        $this->create_page = false;
        $this->perms_page = false;
        $this->update_page = false;
        $this->photo = null;
    }

    public function updateUserForm($id)
    {
        $this->resPage();
        $this->update_page = true;
        $this->user_id = $id;
        $this->user = Users::find($id);
        $this->is_active = $this->user->is_active;
        $this->emit('getUserId', $id);
    }

    public function permUserForm($id)
    {
        $this->resPage();
        $this->perms_page = true;
        $this->user_id = $id;
        $this->user = Users::find($id);
        $this->is_active = $this->user->is_active;
        $this->emit('getUserId', $id);
    }

    public function store()
    {
        //$this->validate();
        $user = Users::find($this->user_id);
        $user->user_name = $this->user_name;
        $user->email = $this->email;
        $user->user_code = $this->user_code;
        $user->password = $this->password;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->logo_user = $this->logo_user;
        $user->logo_password = $this->logo_password;
        $user->is_active = $this->is_active;
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
        $user->user_code = $this->user_code;
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


    public function foto_save()
    {
        $p = $this->photo;
        $photo_name = $this->user_id . "_" . substr(uniqid(rand(), true), 8, 8) . "." . $p->getClientOriginalExtension();
        $img = Image::make($p->getRealPath())->encode('jpg', 65)->fit(300, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $path = 'images/users';
        Storage::disk('public')->put($path . '/' . $photo_name, $img, 'public');

        $user = Users::find($this->user_id);
        $user->photo_path = $photo_name;
        $user->save();
        $this->photo = null;
        return session()->flash('success', 'Fotoğraf Yüklendi...');
    }

    public function remove_photo()
    {
        $user = Users::find($this->user_id);
        $file_path =  $user->photo_path;
        $user->photo_path = null;
        $user->save();
        $this->photo = null;

        unlink(public_path('/files/images/users/') . $file_path);
    }
}