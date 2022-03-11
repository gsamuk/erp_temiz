<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PasswordChange extends Component
{

    public $user_id, $password, $password_confirm;
    public function render()
    {
        return view('livewire.user.password-change');
    }


    public function store(Request $request)
    {
        if (strlen($this->password) < 4) {
            return session()->flash('error', 'Şifre En Az 4 Hanel Olmalı ');
        }

        if ($this->password != $this->password_confirm) {
            return session()->flash('error', 'Şifreler Aynı Olmalı ');
        }

        Users::Where("id", $this->user_id)
            ->update([
                'password' => $this->password,
            ]);
        session()->flash('message', 'Güncelleme Başarılı');
    }
}
