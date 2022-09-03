<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\EsitW1;
use App\Models\EsitW2;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('esitw1', function (Request $request) {
    $data = $request->all();
    $data = $data[0];
    $tno = $data['TicketNo'];
    $scale = $data['Scale'];

    $new = EsitW1::updateOrCreate(
        ['TicketNo' => $tno, 'Scale' => $scale],
        $data
    );
    return $new;
});


Route::post('esitw2', function (Request $request) {
    $data = $request->all();
    $data = $data[0];
    $tno = $data['TicketNo'];
    $scale = $data['Scale'];

    $new = EsitW2::updateOrCreate(
        ['TicketNo' => $tno, 'Scale' => $scale],
        $data
    );
    $deleted = EsitW1::where('TicketNo', $tno)->delete();
    return $new;
});