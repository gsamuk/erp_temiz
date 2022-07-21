<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{

    public $page;
    public $edit_id;

    protected $listeners = ['SetPage', 'EditDemand'];

    public function SetPage($page)
    {
        $this->edit_id = null;
        $this->page = $page;
    }

    public function EditDemand($id)
    {
        $this->edit_id = $id;
        $this->page = 'malzemeler.talep-olustur';
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}