<?php

namespace App\Http\Livewire\Kantar;


use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\KantarFiles;
use App\Models\Kantar;
use App\Helpers\Erp;
use App\Models\KantarData;
use Illuminate\Support\Str;



class FileUpload extends Component
{

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kantar_id;
    public $file;
    public $search_kantar;

    public $line;
    public $setFile;
    public $setReport;

    public $x;

    ///////

    protected $listeners = ['Yenile' => '$refresh'];




    public function render()
    {
        $data = KantarFiles::where('id', '>', 0)
            ->when($this->search_kantar, function ($query) {
                return $query->where('kantar_id', $this->search_kantar);
            })->orderBy('id', 'DESC')->paginate(5);

        $kantarlar = Kantar::all();
        return view('livewire.kantar.file-upload', ['data' => $data, 'kantarlar' => $kantarlar]);
    }


    public function save()
    {
        $this->line = null;

        if (!$this->file) {
            session()->flash('error', 'Lütfen Dosya Seçin.');
            return;
        }

        if (!$this->kantar_id) {
            session()->flash('error', 'Lütfen Kantar Seçin.');
            return;
        }

        $file = $this->file;
        $original_filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = date('dmYHis') . "_" . Str::random(3) . "." . $extension;


        $this->file->storeAs('kantar_raporlari', $fileName);

        $fup = new KantarFiles;
        $fup->user_id = Erp::user_id();
        $fup->file_name = $fileName;
        $fup->original_file_name = $original_filename;
        $fup->kantar_id =  $this->kantar_id;
        $fup->insert_time = date('Y-m-d H:i:s');
        $fup->save();
        $this->file = null;
        $this->kantar = null;
        session()->flash('success', 'Dosya Sisteme Eklendi...');
        $this->set_file($fup->id);
    }


    public function set_file($id)
    {
        $this->line = $id;
        $this->setReport = null;
        $this->setFile = $id;
        $this->emit('SetFile', $id);
    }

    public function set_report($id)
    {
        $this->line = $id;
        $this->setFile = null;
        $this->setReport = $id;
        $this->emit('SetReport', $id);
    }


    public function sil($id)
    {
        $up = KantarFiles::find($id);
        $up->delete();
        $dt = KantarData::where('file_id', $id)->delete();
        $this->emitself('Yenile');
        $this->setFile = null;
    }
}