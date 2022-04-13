<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;

use App\Models\LogoItems;
use Livewire\WithPagination;

class ListeDetayli extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $code = '';
    public $tur = '';
    public $stur = '';

    public function render()
    {

        $data = LogoItems::where('stock_name', 'like', '%' . $this->search . '%')
            ->when($this->tur, function ($query) {
                return $query->where('cardtype_name', $this->tur);
            })
            ->when($this->code, function ($query) {
                return $query->where('stock_code', $this->code);
            })
            ->when($this->stur, function ($query) {
                return $query->where('stock_type', $this->stur);
            })
            ->orderByDesc('stock_name')
            ->paginate(20);

        $item_type = LogoItems::select('cardtype_name')->distinct()->get();
        $stock_type = LogoItems::select('stock_type')->distinct()->get();


        return view('livewire.malzemeler.liste-detayli', [
            'items' => $data,
            'item_type' => $item_type,
            'stock_type' => $stock_type
        ]);
    }
}
