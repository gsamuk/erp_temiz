<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\LogoTokenController;


class FirmaSec extends Component
{
    public $firma;
    public $firma_adi;
    public $btn;

    public function mount()
    {
        $this->btn = true;
        if (Cookie::has('secili_firma')) {
            $this->firma = Cookie::get('secili_firma');
        }
    }

    public function setName($name)
    {
        $this->firma_adi = $name;
    }

    public function render()
    {
        return view('livewire.user.firma-sec');
    }


    public function store()
    {
        if ($this->firma == null || empty($this->firma)) {
            session()->flash('error', 'Lütfen Firma Seçin!');
        } else {

            Cookie::queue(Cookie::make('secili_firma', $this->firma, 500000));
            Cookie::queue(Cookie::make('secili_firma_adi', $this->firma_adi, 500000));
            $token = LogoTokenController::getToken($this->firma);
            if ($token) {
                $this->btn = false;
                session()->flash('message', 'Geçiş Yapıldı, lütfen sayfayı yenileyiniz! ');
            }
        }
    }
}
