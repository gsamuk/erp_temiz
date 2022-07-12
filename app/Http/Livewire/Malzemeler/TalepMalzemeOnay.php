<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\WithPagination;
use Livewire\Component;

use App\Models\DemandDetail;

class TalepMalzemeOnay extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = DemandDetail::orderBy('demand.id', 'desc')->select(
            "demand_detail.*",
            "demand_detail.id as dt_id",
            "demand.*"

        )->where('demand_detail.status', 5)
            ->join("demand", "demand.id", "=", "demand_detail.demand_id")
            ->paginate(10);
        //dd($data);
        return view('livewire.malzemeler.talep-malzeme-onay', [
            'data' => $data
        ]);
    }

    public function onay($id, $c, $p)
    {
        $up = DemandDetail::find($id);
        $up->approved_consump = $c;
        $up->approved_purchase = $p;
        $up->status = 6;
        $up->save();
    }


    public function islem($id, $status)
    {
        $up = DemandDetail::find($id);
        $up->status = $status;
        $up->save();
    }
}