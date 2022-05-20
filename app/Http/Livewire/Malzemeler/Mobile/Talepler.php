<?php

namespace App\Http\Livewire\Malzemeler\Mobile;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Demand;
use App\Models\DemandDetail;

class Talepler extends Component
{
    public $user_id;


    public function mount()
    {
        $this->user_id = Session::get('userData')->id;
    }


    public function render()
    {
        $talepler = Demand::where('users_id', $this->user_id)
            ->orderBy('id', 'desc')->limit(10)
            ->get();

        return view('livewire.malzemeler.mobile.talepler', ['talepler' => $talepler]);
    }
}
