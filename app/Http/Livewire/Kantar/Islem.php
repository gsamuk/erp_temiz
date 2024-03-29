<?php

namespace App\Http\Livewire\Kantar;


use App\Helpers\Erp;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\KantarData;
use App\Models\LogoAccountsAll;
use App\Models\KantarFiles;
use App\Models\LogoItems;
use App\Models\LogoDb;
use App\Http\Controllers\LogoRest;
use Illuminate\Support\Facades\DB;
use App\Models\LogoSaleDispatche;

class Islem extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $file_id;
    public $file_data;
    public $file;
    public $linecount;

    public $fiyat;
    public $nakliye;
    public $ambar;

    // serach
    public $fisno;
    public $plaka;
    public $firma;
    public $tip;
    public $irs;


    protected $listeners = ['SetFile', 'Yenile' => '$refresh'];

    public function search_reset()
    {
        $this->fisno = null;
        $this->plaka = null;
        $this->firma = null;
        $this->tip = null;
        $this->irs = null;
    }

    public function render()
    {
        $data = KantarData::Where('file_id', $this->file_id)
            ->when($this->fisno, function ($query) {
                return $query->where('fis_no', $this->fisno);
            })
            ->when($this->tip, function ($query) {
                return $query->where('list_type', $this->tip);
            })
            ->when($this->irs, function ($query) {
                if ($this->irs == 1) {
                    return $query->where('logo_fiche_ref', '>', 0);
                } else {
                    return $query->where('logo_fiche_ref', '=', null);
                }
            })
            ->when($this->firma, function ($query) {
                return $query->where('firma', 'like', '%' . $this->firma . '%');
            })
            ->when($this->plaka, function ($query) {
                return $query->where('plaka', 'like', '%' . $this->plaka . '%');
            })

            ->orderBy('fis_no', 'DESC')
            ->paginate(500);

        return view('livewire.kantar.islem', ['data' => $data]);
    }



    public function updatedFiyat($value, $id)
    {
        $up = KantarData::find($id);
        $up->birim_fiyat = $value;
        $up->save();
    }


    public function updatedNakliye($value, $id)
    {
        $up = KantarData::find($id);
        $up->nakliye_birim_fiyat = $value;
        $up->save();
    }

    public function updatedAmbar($value, $id)
    {
        $up = KantarData::find($id);
        $up->ambar_no = $value;
        $up->save();
    }



    public function SetFile($id)
    {
        $this->search_reset();
        $this->linecount = null;
        $this->file_id = $id;
        $data = KantarFiles::find($id);
        $this->file_data = $data;
        $file = fopen(public_path("files/kantar_raporlari/" . $data->file_name), "r");
        $linecount = -1;
        while (!feof($file)) {
            $line = fgets($file);
            $linecount++;
        }
        fclose($file);
        $this->linecount = $linecount;
    }

    public function kontrol()
    {

        $file = fopen(public_path("files/kantar_raporlari/" . $this->file_data->file_name), "r");
        $linecount = 0;
        $chk = true;
        $msg = "";
        while (!feof($file)) {

            $line = fgets($file);
            $konum = strpos($line, 'Plaka');
            $konum_ = strpos($line, 'Tarih');

            if ($konum === false && $konum_ === false) {
                if (strlen($line) > 10) {
                    $linecount++;
                    $arr = explode(';', $line);

                    list($no, $plaka, $fisno, $hesap_no, $hesap_adi, $stok_code, $stock_name, $ts1, $ts2, $t1, $t2, $net, $l) = $arr;
                    $malzeme = LogoItems::Where('stock_code', $stok_code)->first();
                    if (!$malzeme) {
                        $msg .= "Bilinmeyen Malzeme, Stok Kodu: <b> $stok_code </b> | <b>Fiş No : $fisno </b> <br> ";
                        $chk = false;
                    }

                    $hesap = LogoAccountsAll::Where('account_code', $hesap_no)->first();
                    if (!$hesap) {
                        $msg .= "Bilinmeyen Cari, Hesap Kodu: <b> $hesap_no </b> | <b>Fiş No : $fisno </b><br> ";
                        $chk = false;
                    }

                    $plaka = trim($plaka);
                    $arr = str_split($plaka);

                    if ($arr[0] == 0 && $arr[2] == 'Z') {
                        $plaka = str_replace('Z', '-', $plaka);
                        $plaka_malzeme = LogoItems::Where('stock_code', $plaka)->first();
                        if (!$plaka_malzeme) {
                            $msg .= "Bilinmeyen Nakliye Kodu: <b> $plaka </b> | <b>Fiş No : $fisno </b> <br> ";
                            $chk = false;
                        }
                    }
                }
            }
        }
        fclose($file);
        $up = KantarFiles::find($this->file_id);
        if ($chk) {
            $up->kontrol = 1;
            $this->emitSelf('Yenile');
        } else {
            $up->kontrol = 2;
            $up->bozuk_satirlar = $msg;
            session()->flash('error', $msg);
        }
        $up->save();
    }


    public function save()
    {
        $file = fopen(public_path("files/kantar_raporlari/" . $this->file_data->file_name), "r");
        $linecount = 0;
        $added_data = false;
        while (!feof($file)) {

            $line = fgets($file);
            $konum = strpos($line, 'Plaka');
            $konum_ = strpos($line, 'Tarih');

            if ($konum === false && $konum_ === false) {
                if (strlen($line) > 10) {
                    ////////// start
                    $birim_fiyat = 6000; // default satış fiyatı logodan gelecek 
                    $nakliye_birim_fiyat = 680; // default satış fiyatı logodan gelecek
                    $ambar_no = 0; // ambar   

                    $linecount++;
                    $arr = explode(';', $line);
                    list($no, $plaka, $fisno, $hesap_no, $hesap_adi, $stok_code, $stock_name, $ts1, $ts2, $t1, $t2, $net, $l) = $arr;

                    // satır daha önce eklenmişmi
                    $md5 = md5($fisno . $this->file_data->kantar_id);
                    $is_have = KantarData::Where('md5_data', $md5)->first();
                    if ($is_have) {
                        continue;
                    }
                    //

                    $malzeme = LogoItems::Where('stock_code', $stok_code)->first();

                    $plaka = trim($plaka);
                    $arr = str_split($plaka);

                    if ($arr[0] == 0 && $arr[2] == 'Z') {
                        $plaka = str_replace('Z', '-', $plaka);
                        $list_type = 2;
                    } else {
                        $list_type = 1;
                    }


                    // eğer firma kodu sorunsuz ise
                    $br = DB::select(
                        "Exec dbo.sp_get_last_sale_account @company_id ='001',
                    @term_id = '10', @rowcount = 1,
                    @item_ref = '$malzeme->logicalref',
                    @account_no =  '$hesap_no', 
                    @wh_no = 0",
                    );


                    if (count($br) > 0) {
                        // firmaya bu malzeme en son kaça satılmış bilgisi alınıyor
                        $birim_fiyat = $br[0]->unit_price;
                        $ambar_no = $br[0]->warehouse_no;
                    } else {

                        $birim_fiyat = 0;
                        $ambar_no = -1;
                    }

                    if ($list_type == 2) {
                        // eğer nakliye varsa 
                        // dd($plaka);
                        $malzeme_ = LogoItems::Where('stock_code', $plaka)->first();
                        $nbr = DB::select(
                            "Exec dbo.sp_get_last_sale_account @company_id ='001',
                        @term_id = '10', @rowcount = 1,
                        @item_ref = '$malzeme_->logicalref',
                        @account_no =  '$hesap_no', 
                        @wh_no = 0",
                        );

                        if (count($nbr) > 0) {
                            // firmanın son nakliye birim fiyatı alınıyor
                            $nakliye_birim_fiyat = $nbr[0]->unit_price;
                        } else {

                            $nakliye_birim_fiyat = 0;
                        }
                    }




                    $e = new KantarData;
                    $e->user_id = Erp::user_id();
                    $e->kantar_id = $this->file_data->kantar_id;
                    $e->plaka = $plaka;
                    $e->fis_no = $fisno;

                    /////////////////
                    $e->firma = $hesap_adi;
                    $e->firma_kod = $hesap_no;

                    $e->malzeme =  $malzeme->stock_name;
                    $e->malzeme_sku = $malzeme->stock_code;
                    //////////////
                    $e->tarti_giris_zaman = $ts1;
                    $e->tarti_cikis_zaman = $ts2;
                    $e->tarti_giris = $t1;
                    $e->tarti_cikis = $t2;
                    $e->tarti_net = $net;
                    $e->birim_fiyat = $birim_fiyat;
                    $e->ambar_no = $ambar_no;

                    if ($list_type == 2) {
                        $e->nakliye_birim_fiyat = $nakliye_birim_fiyat;
                    }

                    $e->file_id = $this->file_id;

                    $e->md5_data = $md5;
                    $e->raw_data = $line;
                    $e->list_type = $list_type; // tip nakliye varsa 2 yoksa 1
                    $e->insert_time = date('Y-m-d H:i:s');

                    $e->save();
                    $added_data = true;
                    /////   end
                }
            }
        }
        fclose($file);


        if ($added_data) { // eğer veri işleme başarılı ise
            $up = KantarFiles::find($this->file_id);
            $up->islem = 1;
            $up->save();
            $this->emitSelf('Yenile');
        } else {
            session()->flash('error', "Bu dosyadaki veriler zaten eklenmiş, lütfen bu dosyayı sistem siliniz.");
        }
    }


    public function toplu_irsaliye()
    {
        $data = KantarData::Where('file_id', $this->file_id)
            ->Where('ambar_no', '>=', 0)
            ->where('birim_fiyat', '>', 0)
            ->Where('logo_fiche_ref', null)->get();
        foreach ($data as $d) {
            $this->irsaliye($d->id);
        }
        session()->flash('success', "Uygun Verilerin İrsaliyeleri Oluşturuldu...");
    }



    public function irsaliye_sil($id)
    {
        $d = KantarData::find($id);
        $ft = LogoSaleDispatche::find($d->logo_fiche_ref);
        if ($ft->billed == 0) {
            $r = LogoRest::IrsaliyeSil($d->logo_fiche_ref);
            if ($r['success'] == true) {
                $d->logo_fiche_ref = null;
                $d->save();
            } else {
                dd($r);
            }
        }
    }

    public function irsaliye($id)
    {
        $d = KantarData::find($id);
        $item = LogoDb::Where('stock_code', $d->malzeme_sku)->first();
        $rest_items = array();

        $rest_items[] = [
            "STOCKREF" => $item->logicalref,
            "UNIT_CODE" => "TON",
            "TYPE" => 0,
            "TRCODE" => 8,
            "SOURCEINDEX" => $d->ambar_no,
            "SOURCECOSTGRP" => $d->ambar_no,
            'QUANTITY' => ($d->tarti_net / 1000),
            "DESCRIPTION" => $d->plaka,
            "PRICE" => $d->birim_fiyat,
        ];

        if ($d->list_type == 2) {
            $item = LogoDb::Where('stock_code', $d->plaka)->first();
            $rest_items[] = [
                "STOCKREF" => $item->logicalref,
                "UNIT_CODE" => "TON",
                "TYPE" => 0,
                "TRCODE" => 8,
                "SOURCEINDEX" => $d->ambar_no,
                "SOURCECOSTGRP" => $d->ambar_no,
                'QUANTITY' => ($d->tarti_net / 1000),
                "DESCRIPTION" => $d->plaka,
                "PRICE" => $d->nakliye_birim_fiyat,
            ];
        }

        $k = str_split($d->firma_kod);
        $gl_code = $k[0] . $k[1] . $k[2] . "." . $k[3] . $k[4] . "." . $k[5] . $k[6] . "." . $k[7] . $k[8] . $k[9] . "." . $k[10] . $k[11] . $k[12];


        if ($d->ambar_no == 20 || $d->ambar_no == 21) {
            $proje_kodu = "KADUNA";
        } else {
            $proje_kodu = null;
        }


        $irs_data = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'GROUP' => 2,
            'TYPE' => 8,
            'IO_TYPE' => 3,
            'DATE' => $d->tarti_cikis_zaman,
            'TIME' => 134682914,
            'DOC_DATE' => date('Y-m-d'),
            'DOC_TIME' => 134682914,
            'SHIP_DATE' => date('Y-m-d'),
            'SHIP_TIME' => 134682914,
            "SOURCE_WH" => $d->ambar_no,
            "SOURCE_COST_GRP" => $d->ambar_no,
            'DOC_NUMBER' => $d->fis_no,
            'ARP_CODE' =>  $d->firma_kod,
            'GL_CODE' =>   $gl_code,
            'DISP_STATUS' =>  1, // SEVK EDİLDİ
            'PROJECT_CODE' => $proje_kodu,
            'CURRSEL_TOTALS' => 1,
            "STATUS" => 0,  // 1:Öneri 0:Gerçek
            "EDESPATCH_STATUS" => 12,
            'TRANSACTIONS' => [
                'items' => $rest_items
            ]
        ];

        $ref  = LogoRest::IrsaliyeFisiOlustur($irs_data, 0);
        if ($ref != null && $ref > 0) {
            $d->logo_fiche_ref = $ref;
            $d->save();
        } else {
            return false;
        }
    }

    public function satir_sil($id)
    {
        $d = KantarData::find($id);
        $d->delete();
    }
}