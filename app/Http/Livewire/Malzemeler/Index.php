<?php

namespace App\Http\Livewire\Malzemeler;

use App\Models\LogoDb;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function render()
    {
        return view('livewire.malzemeler.index', [
            'items' => LogoDb::where('MALZEME_ADI', 'like', '%' . $this->search . '%')
                ->orWhere('MALZEME_KODU', 'like', '%' . $this->search . '%')
                ->orderByDesc('MALZEME_ADI')
                ->paginate(15),
        ]);
    }
}
