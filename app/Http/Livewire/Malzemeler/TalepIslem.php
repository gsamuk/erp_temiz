<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;
use App\Models\Demand;
use App\Models\DemandDetail;
use Illuminate\Support\Facades\DB;
use App\Models\LogoPurchaseOrdersDetail;


class TalepIslem extends Component
{
    public $error;
    public $talep;
    public $talep_id;
    public $talep_detay;
    public $talep_;
    public $demand_fiche;



    public $sarf;





    protected $listeners = ['TalepIslem'];

    public function TalepIslem($id)
    {
        $this->sarf = null;
        $this->error = null;
        $this->talep_id = $id;
        $this->talep = Demand::find($id);
        $this->talep_detay = DemandDetail::Where('demand_id', $id)->Where('status', '!=', 9)->get();
        if ($this->talep_detay->count() == 0) {
            $this->talep_detay = null;
        }
        $this->demand_fiche = DB::select(
            "Exec dbo.sp_get_consump_fiche  
            @company_id ='001', 
            @term_id = '09', 
            @detail = 1, 
            @fiche_no = '', 
            @demand_id = ?",
            array($this->talep_id)
        );
    }


    public function sarf_olustur()
    {
        dd($this->sarf);
    }

    public function render()
    {
        return view('livewire.malzemeler.talep-islem');
    }
}
