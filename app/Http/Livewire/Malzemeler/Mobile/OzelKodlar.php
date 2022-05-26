<?php

namespace App\Http\Livewire\Malzemeler\Mobile;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LogoOzelKod;

class OzelKodlar extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search_code = '';
    public $search_name = '';



    public function render()
    {
        $data = LogoOzelKod::when($this->search_code, function ($query) {
            return $query->where('special_code', 'like', '%' . $this->search_code . '%');
        })
            ->when($this->search_name, function ($query) {
                return $query->where('special_name', 'like', '%' . $this->search_name . '%');
            })
            ->orderByDesc('special_code')
            ->paginate(8);

        return view('livewire.malzemeler.mobile.ozel-kodlar', [
            'data' => $data,
        ]);
    }
}
