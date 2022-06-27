<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;

class Response extends Component
{

    public $error = [];
    public $success = [];

    protected $listeners = ['Success', 'Error'];

    public function Success($msg)
    {
        array_push($this->success, $msg);
    }

    public function Error($msg)
    {
        array_push($this->error, $msg);
    }

    public function render()
    {
        return view('livewire.malzemeler.response');
    }
}