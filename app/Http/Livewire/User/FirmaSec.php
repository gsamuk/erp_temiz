<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LogoTokenController;
use App\Models\Company;


class FirmaSec extends Component
{
    public $firma = 1;
    public $firma_adi;
    public $btn;

    public function mount()
    {
        $this->btn = true;
        if (Session::has('secili_firma')) {
            $this->firma = Session::get('secili_firma');
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
            $firma = Company::Where("logo_firmnr", $this->firma)->first();

            session()->put('secili_firma', $firma->logo_firmnr);
            session()->put('secili_firma_adi', $firma->logo_firm_name);
            session()->put('secili_db_kod', $firma->db_code);

            $token = LogoTokenController::getToken($this->firma);
            if ($token) {
                $this->btn = false;
                session()->flash('message', 'Geçiş Yapıldı, bu pencereyi kapatabilirsiniz. ');
            } else {
                $this->btn = true;
                session()->flash('error', 'Sorun, Lütfen logları kontrol ediniz. ');
            }
        }
    }
}