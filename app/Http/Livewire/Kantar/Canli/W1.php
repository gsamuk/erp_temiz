<?php

namespace App\Http\Livewire\Kantar\Canli;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\EsitW1;

class W1 extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = EsitW1::orderby('TicketNo', 'desc')->paginate(10);
        return view('livewire.kantar.canli.w1', [
            'data' => $data
        ]);
    }
}