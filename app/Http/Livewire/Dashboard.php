<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{

    public $d1;
    public $d2;

    public function render()
    {
        return view('livewire.dashboard');
    }
}
