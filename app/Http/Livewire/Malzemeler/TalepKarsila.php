<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;

class TalepKarsila extends Component
{
    public $talep_id;

    protected $listeners = ['TalepYenile' => 'TalepYenile'];

    public function TalepYenile($id)
    {
        $this->talep_id = $id;
    }

    public function render()
    {
        return view('livewire.malzemeler.talep-karsila');
    }
}
