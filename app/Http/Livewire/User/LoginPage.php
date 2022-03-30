<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\LogoUserTokens;
use App\Models\Users;


class LoginPage extends Component
{
    public $password;
    public $user_name;
    public $rememberme;
    public $err;
    public $durum;


    protected $rules = [
        'user_name' => 'required',
        'password' => 'required',
    ];

    protected $messages = [
        'password.required' => 'Kullanıcı Şifresi giriniz',
        'user_name.required' => 'Kullanıcı adı giriniz',
    ];

    public function render()
    {
        return view('livewire.user.login-page');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        if (Cookie::has('rememberme')) {
            $this->rememberme = true;
        }
        if (Cookie::has('password')) {
            $this->password = Cookie::get('password');
        }
        if (Cookie::has('user_name')) {
            $this->user_name = Cookie::get('user_name');
        }
    }

    public function login(Request $request)
    {

        $this->validate();
        $active = Users::where('is_active', 0)->where('user_name', $this->user_name)->first();
        if ($active) {
            return redirect("login")->with('message', 'Bu Kullanıcı Hesabı Kapalı! Eğer bir sorun olduğunu düşünüyorsanız sistem yöneticisi iletişime geçiniz.');
        }

        $user = Users::where('users.user_name', $this->user_name)
            ->where('users.password', $this->password)
            ->where('users.is_active', 1)
            ->join('Authorizations', 'users.id', '=', 'authorizations.user_id')
            ->select(
                'users.*',
                'authorizations.purchase_view',
                'authorizations.sale_view',
                'authorizations.purchase_approve',
                'authorizations.sale_approve',
                'authorizations.is_admin'
            )
            ->first();

        if ($user) {



            $request->session()->put('userData', $user);

            if ($this->rememberme) {
                Cookie::queue(Cookie::make('rememberme', true, 500000));
                Cookie::queue(Cookie::make('password', $this->password, 500000));
                Cookie::queue(Cookie::make('user_name', $this->user_name, 500000));
            } else {
                Cookie::queue(Cookie::forget('rememberme'));
                Cookie::queue(Cookie::forget('password'));
                Cookie::queue(Cookie::forget('user_name'));
            }

            return redirect()->to('/');
        } else {

            $request->session()->forget('userData');
            $request->session()->forget('LogoData');
            $request->session()->put('LogoLogin', false);
            $this->err = "Hatalı Kullanıcı Adı yada Şifre";
        }
    }
}
