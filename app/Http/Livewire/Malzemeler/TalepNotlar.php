<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;
use App\Models\DemandNote;
use App\Helpers\Erp;

class TalepNotlar extends Component
{
    public $talep_id;
    public $notes;

    protected $listeners = ['SetDemandId' => 'SetDemandId'];

    public function SetDemandId($id)
    {
        $this->talep_id = $id;
    }

    public function render()
    {
        $data = DemandNote::Where('demand_id', $this->talep_id)->orderby('id', 'desc')->get();
        return view('livewire.malzemeler.talep-notlar',  [
            'data' => $data
        ]);
    }

    public function save_note()
    {
        $n = new DemandNote;
        $n->demand_id = $this->talep_id;
        $n->note = $this->notes;
        $n->users_id = Erp::user_id();
        $n->insert_time = date('Y-m-d H:i:s');
        $n->save();
        $this->notes = null;
    }

    public function delete_not($id)
    {
        $n = DemandNote::find($id);
        $n->delete();
    }
}