<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;
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
            $firma = Company::Where("logo_firmnr", $this->firma)->first();


            Cookie::make('secili_firma', $firma->logo_firmnr, 500000);
            Cookie::make('secili_firma_adi', $firma->logo_firm_name, 500000);
            Cookie::make('secili_db_kod', $firma->db_code, 500000);


            $token = LogoTokenController::getToken($this->firma);
            if ($token) {
                $this->btn = false;
                session()->flash('message', 'Geçiş Yapıldı, lütfen sayfayı yenileyiniz! ');
            } else {
                $this->btn = true;
                session()->flash('error', 'Sorun, Lütfen logları kontrol ediniz. ');
            }
        }
    }
}
