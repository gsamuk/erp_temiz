<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;

use App\Models\LogoItems;

use Intervention\Image\Facades\Image;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\LogoItemsPhoto;

class Fotograf extends Component
{

    use WithFileUploads;

    public $search, $isEmpty;
    public $code;
    public $ref;
    public $photo;
    public $item;
    public $item_photos;

    public function render()
    {
        if (!empty($this->search) || !empty($this->code)) {
            $data = LogoItems::where('logicalref', '>', 0)
                ->when($this->search, function ($query) {
                    return $query->where('stock_name', 'like', '%' . $this->search . '%');
                })
                ->when($this->code, function ($query) {
                    return $query->where('stock_code', $this->code);
                })

                ->take(5)
                ->get();

            $this->isEmpty = '';
        } else {
            $data = [];
            $this->isEmpty = __('Nothings Found.');
        }


        return view('livewire.malzemeler.fotograf', [
            'data' => $data,
        ]);
    }


    public function get_foto($ref)
    {
        $this->ref = $ref;
        $this->item = LogoItems::find($ref);
        $this->item_photos = LogoItemsPhoto::Where('logo_stockref', $ref)->get();
        $this->photo = null;
    }


    public function save()
    {
        $p = $this->photo;
        $name = substr(uniqid(rand(), true), 8, 8) . "." . $p->getClientOriginalExtension();
        $img = Image::make($p->getRealPath())->encode('jpg', 65)->fit(300, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $img->stream(); // <-- Key point
        $fname = $this->ref . "_" . $this->item->stock_code . "_" . $name;
        $path = 'public/images/items';
        Storage::disk('local')->put($path . '/' . $fname, $img, 'public');

        $item = new LogoItemsPhoto;

        $item->company_id = 1;
        $item->logo_stockref = $this->ref;
        $item->stock_code = $this->item->stock_code;
        $item->stock_name = $this->item->stock_name;
        $item->foto_path = $fname;
        $item->save();
        $this->photo = null;

        return session()->flash('success', 'Yüklendi...');
    }
}
