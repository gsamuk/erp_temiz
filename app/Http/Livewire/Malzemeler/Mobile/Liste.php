<?php

namespace App\Http\Livewire\Malzemeler\Mobile;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use App\Models\LogoItems;
use App\Models\LogoDb;
use App\Models\LogoItemsPhoto;
use App\Models\LogoUnits;
use App\Models\MobileDemanDetailTemp;

class Liste extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $search_stock_code;


    public $slc_item_type;
    public $slc_stock_type;
    public $perPage = 3;
    public $malzeme;
    public $malzeme_units;
    public $malzeme_birim;


    public $talep_miktar;
    public $talep_neden = "İhtiyaç";


    public function render()
    {
        $malzemeler = LogoItems::where('stock_name', 'like', '%' . $this->search . '%')
            ->when(!empty($this->slc_item_type), function ($query) {
                return $query->where('cardtype_name', $this->slc_item_type);
            })
            ->when(!empty($this->search_stock_code), function ($query) {
                return $query->where('stock_code', $this->search_stock_code);
            })
            ->when(!empty($this->slc_stock_type), function ($query) {
                return $query->where('stock_type', $this->slc_stock_type);
            })
            ->orderBy('stock_name', 'desc')
            ->paginate($this->perPage);

        $item_type = LogoDb::select('cardtype_name')->distinct()->get();
        $stock_type = LogoDb::select('stock_type')->distinct()->get();
        $talep_listesi = MobileDemanDetailTemp::where('user_id', 1)->get();

        return view(
            'livewire.malzemeler.mobile.liste',
            [
                'malzemeler' => $malzemeler,
                'item_type' => $item_type,
                'stock_type' => $stock_type,
                'talep_listesi' => $talep_listesi,
            ]
        );
    }

    public function loadMore()
    {
        $this->perPage += 3;
    }

    public function ekle()
    {
        $db = new MobileDemanDetailTemp;
        $db->user_id = 1;
        $db->logo_stock_ref = $this->malzeme->logicalref;
        $db->quantity = $this->talep_miktar;
        $db->unit_code = $this->malzeme_birim;
        $db->description = $this->talep_neden;
        $db->insert_time = date('Y-m-d H:i:s');
        $db->save();
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function sil($id)
    {
        MobileDemanDetailTemp::where('id', $id)->where('user_id', 1)->delete();
        $sayi = MobileDemanDetailTemp::where('user_id', 1)->count();
        if ($sayi == 0) {
            $this->dispatchBrowserEvent('CloseTalepListModal');
        }
    }

    public function getMalzeme($ref)
    {
        $this->talep_miktar = null;
        $this->malzeme = LogoItems::find($ref);
        $this->malzeme_photos = LogoItemsPhoto::Where('logo_stockref', $ref)->get();
        $this->malzeme_units = LogoUnits::Where('unitset_ref', $this->malzeme->unitset_ref)->get();

        $this->malzeme_birim = $this->malzeme_units[0]['unit_code'];
        $this->dispatchBrowserEvent('ShowModal');
    }
}
