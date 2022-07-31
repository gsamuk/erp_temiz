<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LogoItemsPhoto;


class MakePdf extends Controller
{

    public function make($id = 0)
    {
        $data = LogoItemsPhoto::where('id', '>', $id)->distinct()->get('logo_stockref');
        $pdf = PDF::loadView('htmlPdf', ['data' => $data]);
        return $pdf->download('pdfview.pdf');
    }
}