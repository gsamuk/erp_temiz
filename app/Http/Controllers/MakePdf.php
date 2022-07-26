<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LogoItems;


class MakePdf extends Controller
{

    public function make()
    {
        $data = LogoItems::Where('wh_no', 0)->get()->take(10)->toArray();
        $pdf = PDF::loadView('htmlPdf', ['data' => $data]);
        return $pdf->download('pdfview.pdf');
    }
}