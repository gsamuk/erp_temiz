<?php

namespace App\Http\Livewire\Malzemeler;

use App\Models\LogoDb;
use App\Models\LogoItems;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LogoItemsPhoto;
use App\Models\LogoWarehouses;
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
    public $details = true; // true malzeme detay bilgileri gösterir

    public $item;
    public $foto_ref; // malzeme ref id
    public $item_photos;
    public $item_id;

    public $wh_id = '0';

    public $pagination = 8;


    protected $listeners  = ['setLine', 'setWh'];

    public function setLine($id) // hangi satırın seçildiğini listen yaparak alıoyuz  dinliyoruz
    {
        $this->item_id = null;
        $this->line = $id;
    }

    public function setWh($id) // hangi depo seçildyse
    {
        $this->wh_id = $id;
    }


    public function updatedSearch($s): void
    {
        if (!empty($s)) {
            $this->pagination = 80;
        } else {
            $this->pagination = 8;
        }
    }
    public function updatingSearch(): void
    {
        $this->item_id = null;
        $this->code = "";
        $this->resetPage();
    }

    public function updatingCode(): void
    {
        $this->item_id = null;
        $this->search = "";
        $this->resetPage();
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
        $db = new LogoItems;
        $data = $db::where('stock_name', 'like', '%' . $this->search . '%')


            ->when(($this->wh_id >= 0 && $this->wh_id != null), function ($query) {
                return $query->where('wh_no', $this->wh_id);
            })
            ->when($this->tur, function ($query) {
                return $query->where('cardtype_name', $this->tur);
            })
            ->when($this->code, function ($query) {
                return $query->where('stock_code', $this->code);
            })->when($this->stur, function ($query) {
                return $query->where('stock_type', $this->stur);
            })
            ->orderByDesc('stock_name')
            ->paginate($this->pagination);

        $item_type = LogoDb::select('cardtype_name')->distinct()->get();
        $stock_type = LogoDb::select('stock_type')->distinct()->get();
        $warehouses = LogoWarehouses::where('company_no', '1')->get();

        return view('livewire.malzemeler.liste', [
            'items' => $data,
            'item_type' => $item_type,
            'stock_type' => $stock_type,
            'warehouses' => $warehouses,
            'ch' => $this->ch,
            'details' => $this->details
        ]);
    }



    public function remove_foto()
    {
        $this->item_id = null;
    }


    public function foto($id)
    {
        $this->item_id = $id;
        $this->emit('SetRef', $id);
        $this->dispatchBrowserEvent('OpenModal', 'ShowMalzemeFotoModal');
    }
}