<?php

namespace App\Http\Livewire\Malzemeler;

use Livewire\Component;

use App\Models\LogoDb;
use App\Models\LogoUnits;
use App\Models\LogoWarehouses;


class TalepOlustur extends Component
{
    public $line = 0;
    public $i = 0;
    public $inputs = [];
    public $kod;
    public $aciklama;
    public $miktar;
    public $birim;
    public $desc;
    public $meet_type; // karşılama türü 0:satınalma, 1:üretim emri, 2: ambar transfer
    public $meet_stock; // stkotan karşılama 0:evet 1:hayır

    public $warehouse;

    public $birim_select = [];

    public $tid; // sipariş id


    protected $listeners = ["getItem"];

    public function render()
    {
        $data = LogoWarehouses::where('company_no', '1')->get();
        return view('livewire.malzemeler.talep-olustur', [
            'warehouses' => $data,
        ]);
    }


    public function active_line($d)
    {
        $this->line = $d;
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i, $v)
    {
        unset($this->inputs[$i]);
        unset($this->kod[$v]);
    }



    public function getItem($d) // seçilen malzemeyi  dinleyerek set ediyoruz 
    {

        $this->line = $d["line"];
        $item = LogoDb::where('logicalref', $d['ref'])->first();

        $units = LogoUnits::Where('unitset_ref', $item->unitset_ref)->get();
        $this->birim_select[$this->line] = $units;
        $this->birim[$this->line] = $units[0]['unit_code'];


        $this->kod[$this->line] = $item->stock_code;
        $this->aciklama[$this->line] = $item->stock_name;
        $this->miktar[$this->line] = 1; // test


        $this->dispatchBrowserEvent('CloseModal');
    }



    public function store()
    {

        $items = array();

        foreach ($this->kod  as $in => $v) {

            if (!isset($this->miktar[$in]) || $this->miktar[$in] == null) {
                return session()->flash('error', 'Miktar Giriniz');
            }

            if (!isset($this->birim[$in]) || $this->birim[$in] == null) {
                return session()->flash('error', 'Birim Seçiniz');
            }



            $items[] = [
                "MASTER_CODE" => $this->kod[$in],
                "QUANTITY" => $this->miktar[$in],
                "UNIT_CODE" => $this->birim[$in],
            ];
        }


        $data = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'TRANSACTIONS' => [
                'items' => $items
            ]
        ];

        dd($data);
    }
}
