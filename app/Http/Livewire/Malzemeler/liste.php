<?php

namespace App\Http\Livewire\Malzemeler;

use App\Models\LogoDb;
use Livewire\Component;
use Livewire\WithPagination;


class Liste extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $code = '';
    public $tur = '';
    public $line = 0;

    protected $listeners  = ['setLine'];

    public function setLine($id) // hangi satırın seçildiğini listen yaparak alıoyuz siparis.blade i dinliyoruz
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
        $data = LogoDb::where('stock_name', 'like', '%' . $this->search . '%')
            ->when($this->tur, function ($query) {
                return $query->where('cardtype_name', $this->tur);
            })
            ->when($this->code, function ($query) {
                return $query->where('stock_code', $this->code);
            })
            ->orderByDesc('stock_name')
            ->paginate(12);

        $item_type = LogoDb::select('cardtype_name')->distinct()->get();

        return view('livewire.malzemeler.liste', [
            'items' => $data,
            'item_type' => $item_type
        ]);
    }
}
