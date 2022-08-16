<?php

namespace App\Http\Livewire\Kantar;

use Livewire\Component;
use App\Models\LogoAccountsDetails;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class Cariler extends Component
{
    public $search;
    public $kod;
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';



    public function updatingSearch(): void
    {
        $this->kod = "";
        $this->resetPage();
    }

    public function updatingKod(): void
    {
        $this->search = "";
        $this->resetPage();
    }


    public function render()
    {
        $data = LogoAccountsDetails::Where('code_part1', '120')
            ->when($this->kod, function ($query) {
                return $query->where('account_code', 'like', '%' . $this->kod . '%');
            })->when($this->search, function ($query) {
                return $query->where('account_name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.kantar.cariler', ['data' => $data]);
    }
}