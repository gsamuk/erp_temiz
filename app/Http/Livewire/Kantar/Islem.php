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
use Illuminate\Support\Facades\DB;

class Islem extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $file_id;
    public $file_data;
    public $file;
    public $linecount;

    protected $listeners = ['SetFile'];


    public function updatedFiyat($value, $id)
    {
        $up = KantarData::find($id);
        $up->birim_fiyat = $value;
        $up->toplam_fiyat = ($up->tarti_net / 1000) * ($value + $up->nakliye_birim_fiyat);
        $up->save();
    }


    public function updatedNakliye($value, $id)
    {
        $up = KantarData::find($id);
        $up->nakliye_birim_fiyat = $value;
        $up->toplam_fiyat = ($up->tarti_net / 1000) * ($value + $up->birim_fiyat);
        $up->save();
    }


    public function SetFile($id)
    {
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
                        $msg .= "<br>Bilinmeyen Malzeme, Stok Kodu: <b> $stok_code </b> | <b>Fiş No : $fisno </b> ";
                        $chk = false;
                    }

                    $hesap = LogoAccountsAll::Where('account_code', $hesap_no)->first();
                    if (!$hesap) {
                        $msg .= "<br> Bilinmeyen Cari, Hesap Kodu: <b> $hesap_no </b> | <b>Fiş No : $fisno </b> ";
                        $chk = false;
                    }
                }
            }
        }
        fclose($file);
        $up = KantarFiles::find($this->file_id);
        if ($chk) {
            $up->kontrol = 1;
            session()->flash('success', 'Kontrol Başarılı, veri bütünlüğü doğrulandı.');
        } else {
            $up->kontrol = 2;
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
                    $malzeme = LogoItems::Where('stock_code', $stok_code)->first();


                    if (preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $plaka)) {
                        // normal plaka
                        $list_type = 1;
                    } else {
                        // Plaka bölüne Özel Kod Girilen durum                            
                        $plaka = str_replace(' ', '', $plaka); // varsa boşlukları alıyor
                        $list_type = 2;
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
                        $list_type = 0;
                    }

                    if ($list_type == 2) {
                        // eğer nakliye varsa 
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
                            $list_type = 0;
                        }
                    }

                    $tp1 = ($net / 1000) * $birim_fiyat;
                    $tp2 = ($net / 1000) * $nakliye_birim_fiyat;
                    $toplam = $tp1 + $tp2;


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
                    $e->toplam_fiyat = $toplam;
                    $e->md5_data = md5($line);
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
            session()->flash('success', 'Kantar Verileri Sisteme Kayıt Edildi..');
        }
    }


    public function render()
    {
        return view('livewire.kantar.islem');
    }
}