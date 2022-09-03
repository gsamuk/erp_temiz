<?php

namespace App\Http\Livewire\Kantar\Canli;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\EsitW2;

class W2 extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = EsitW2::orderby('TicketNo', 'desc')->paginate(10);
        return view('livewire.kantar.canli.w2', [
            'data' => $data
        ]);
    }
}