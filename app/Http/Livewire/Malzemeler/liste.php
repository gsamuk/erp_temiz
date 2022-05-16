<?php

namespace App\Http\Livewire\Malzemeler;

use App\Models\LogoDb;
use App\Models\LogoItems;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LogoItemsPhoto;
use DB;

class Liste extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $code = '';
    public $tur = '';
    public $stur = '';
    public $line = 0;
    public $ch = true; // true malzeme seçme butonu
    public $details = false; // true malzeme detay bilgileri gösterir

    public $foto_ref; // malzeme ref id
    public $item_photos;

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


    public function detay_goster($d = false)
    {
        $this->details = $d;
    }

    public function render()
    {
        if ($this->details) {
            $db = new LogoItems;
        } else {
            $db = new LogoDb;
        }
        DB::enableQueryLog();
        $data = $db::where('stock_name', 'like', '%' . $this->search . '%')
            ->when($this->tur, function ($query) {
                return $query->where('cardtype_name', $this->tur);
            })
            ->when($this->code, function ($query) {
                return $query->where('stock_code', $this->code);
            })->when($this->stur, function ($query) {
                return $query->where('stock_type', $this->stur);
            })
            ->orderByDesc('stock_name')
            ->paginate(12);
        if ($this->search) {
            dd(DB::getQueryLog());
        }

        $item_type = LogoDb::select('cardtype_name')->distinct()->get();
        $stock_type = LogoDb::select('stock_type')->distinct()->get();


        return view('livewire.malzemeler.liste', [
            'items' => $data,
            'item_type' => $item_type,
            'stock_type' => $stock_type,
            'ch' => $this->ch,
            'details' => $this->details
        ]);
    }


    public function foto($ref)
    {
        $this->foto_ref = $ref;
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $ref)->get();
    }
}
