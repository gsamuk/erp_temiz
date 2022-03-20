<?php

namespace App\Http\Livewire\Malzemeler;

use App\Models\LogoDb;
use Livewire\Component;
use Livewire\WithPagination;
use PhpParser\Node\Expr\FuncCall;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $code = '';
    public $tur = '';
    public $line = 0;

    protected $listener =  ['activeLine' => 'setLine'];

    public function setline()
    {
        dd();
        $this->line = 10;
    }

    public function render()
    {
        $data = LogoDb::where('NAME', 'like', '%' . $this->search . '%')
            ->when($this->tur, function ($query) {
                return $query->where('CARDTYPE', $this->tur);
            })
            ->when($this->code, function ($query) {
                return $query->where('CODE', $this->code);
            })
            ->orderByDesc('NAME')
            ->paginate(10);

        return view('livewire.malzemeler.index', [
            'items' => $data
        ]);
    }
}
