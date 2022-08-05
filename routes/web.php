<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Kontrol;
use App\Http\Middleware\LogoTokenKontrol;
use App\Http\Controllers\UserController;


Route::get('/print/{id}', [App\Http\Controllers\MakePdf::class, 'print']);
Route::get('/pdf/{id}', [App\Http\Controllers\MakePdf::class, 'make']);
Route::get('/qr_create', [App\Http\Controllers\MakePdf::class, 'qr_create']);
Route::post('/qr', [App\Http\Controllers\MakePdf::class, 'qr']);
Route::get('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/login_post', [App\Http\Controllers\LoginController::class, 'login_post'])->name('login.post');
Route::get('signout', [App\Http\Controllers\LoginController::class, 'signout'])->name('signout');



Route::middleware([Kontrol::class])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
    Route::get('/upload', [App\Http\Controllers\HomeController::class, 'upload'])->name('upload');
    Route::middleware([LogoTokenKontrol::class])->group(function () { // logo rest token alınmış ise
        // Token Gerektiren işlemler Middleware Gereklidir
        // satın alma işlemleri
    });

    // Mobil Görünüm işlemleri
    Route::get('/mobile', [App\Http\Controllers\HomeController::class, 'mobile'])->name('mobile');
    Route::get('/mobile/malzeme/talep_olustur', [App\Http\Controllers\HomeController::class, 'talep_olustur'])->name('mobile.malzeme.talep_olustur');
    Route::get('/mobile/malzeme/talepler', [App\Http\Controllers\HomeController::class, 'talepler'])->name('mobile.malzeme.talepler');
    Route::get('/mobile/malzeme/{sku}', [App\Http\Controllers\HomeController::class, 'malzeme_detay'])->name('mobile.malzeme.malzeme_detay');
});