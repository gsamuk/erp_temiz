<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{

    public $page;

    protected $listeners = ['SetPage'];

    public function SetPage($page)
    {
        $this->page = $page;
    }


    public function render()
    {
        return view('livewire.dashboard');
    }
}
