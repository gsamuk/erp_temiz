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
    public $code = '';
    public $tur = '';
    public $line = 0;

    protected $listeners  = ['setLine'];

    public function setLine($id)
    {
        $this->line = $id;
    }


    public function addItem($line, $ref)
    {
        $this->emit('getItem', ['line' => $line, 'ref' => $ref]);
        $this->dispatchBrowserEvent('SetDisable', ['line' => $line]);
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
