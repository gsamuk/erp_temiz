<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LogoItemsPhoto;
use Illuminate\Http\Request;
use App\Models\DemandDetail;
use App\Models\Demand;
use App\Models\LogoWarehouses;

class MakePdf extends Controller
{

    public function make($id = 0)
    {
        $data = LogoItemsPhoto::where('id', '>', $id)->distinct()->get('logo_stockref');
        $pdf = PDF::loadView('htmlPdf', ['data' => $data]);
        return $pdf->download('pdfview.pdf');
    }


    public function qr(Request $request)
    {
        if ($request->kods) {
            $kods = preg_split("/\r\n|\n|\r/", $request->kods);
            $pdf = PDF::loadView('customQrPdf', ['data' => $kods]);
            return $pdf->download('pdfview_Qr.pdf');
        } else {
            //
        }
    }


    public function qr_create()
    {
        return view('qr_create');
    }


    public function print($id)
    {
        $depo_hedef = null;
        $talep = Demand::find($id);
        $detay = DemandDetail::Where('demand_id', $id)->get();
        $depo = LogoWarehouses::Where('warehouse_no', $talep->warehouse_no)->where('company_no', 1)->first();
        if ($talep->dest_wh_no) {
            $depo_hedef = LogoWarehouses::Where('warehouse_no', $talep->dest_wh_no)->where('company_no', 1)->first();
        }
        $pdf = PDF::loadView('DemandPrint', ['talep' => $talep, 'detay' => $detay, 'depo' => $depo, 'depo_hedef' => $depo_hedef], array(), 'UTF-8');
        return $pdf->stream("Talep_$id.pdf");
    }
}