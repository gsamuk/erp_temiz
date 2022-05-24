<?php

namespace App\Http\Livewire\Logo;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LogoProjects;

class Projects extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';


    public function render()
    {
        $data = LogoProjects::where('project_name', 'like', '%' . $this->search . '%')
            ->orderByDesc('project_name')
            ->paginate(10);


        return view('livewire.logo.projects', [
            'projects' => $data,
        ]);
    }
}
