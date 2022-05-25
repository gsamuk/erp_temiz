<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;

use App\Models\LogoItems;

use Intervention\Image\Facades\Image;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Models\LogoItemsPhoto;

class Fotograf extends Component
{

    use WithFileUploads;

    public $search;
    public $code;
    public $ref;
    public $photo;
    public $item;
    public $item_photos;

    public function render()
    {
        DB::enableQueryLog();
        $data = LogoItems::where('logicalref', '>', 0)
            ->when($this->search, function ($query) {
                return $query->where('stock_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->code, function ($query) {
                return $query->where('stock_code', $this->code);
            })->orderBy('logicalref', 'desc')

            ->take(10)
            ->get();
        if ($this->search) {
            // dd(DB::getQueryLog());
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
        $img = Image::make($p->getRealPath())->encode('jpg', 65)->fit(800, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });

        $thumb_img = Image::make($p->getRealPath())->encode('jpg', 65)->fit(200, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });

        $thumb_img->text($this->item->stock_code, 10, 10);
        $img->text($this->item->stock_code, 10, 10);

        $img->stream(); // <-- Key point
        $thumb_img->stream(); // <-- Key point
        $fname = $this->ref . "_" . $this->item->stock_code . "_" . $name;

        $path = 'images/items';
        $thumb_path = 'images/items/thumb';

        Storage::disk('local')->put($path . '/' . $fname, $img, 'public');
        Storage::disk('local')->put($thumb_path . '/' . $fname, $thumb_img, 'public');

        $item = new LogoItemsPhoto;

        $item->company_id = 1;
        $item->logo_stockref = $this->ref;
        $item->stock_code = $this->item->stock_code;
        $item->stock_name = $this->item->stock_name;
        $item->foto_path = $fname;
        $item->save();
        $this->photo = null;
        $this->get_foto($this->ref);
        return session()->flash('success', 'Yüklendi...');
    }


    public function delete_photo($id, $name)
    {
        $img = LogoItemsPhoto::find($id);
        $img->delete();
        unlink(storage_path('/app/public/images/items/') . $name);
        unlink(storage_path('/app/public/images/items/thumb/') . $name);
        $this->get_foto($this->ref);
    }
}
