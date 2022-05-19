<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Kontrol;
use App\Http\Middleware\LogoTokenKontrol;

Route::get('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/login_post', [App\Http\Controllers\LoginController::class, 'login_post'])->name('login.post');
Route::get('signout', [App\Http\Controllers\LoginController::class, 'signout'])->name('signout');

Route::middleware([Kontrol::class])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
    /// user işlemleri    
    Route::post('profil/post', [App\Http\Controllers\UserController::class, 'profil_post'])->name('profil.post');
    Route::post('password/change', [App\Http\Controllers\UserController::class, 'password_change'])->name('profil.password_change_post');
    Route::post('user/authorizations', [App\Http\Controllers\AuthorizationsController::class, 'set_authorizations'])->name('user.authorizations.post');
    Route::get('users', [App\Http\Controllers\UserController::class, 'user_list'])->name("users");

    Route::get('user/{id}', [App\Http\Controllers\UserController::class, 'user'])->name('user');
    Route::get('firma_sec', [App\Http\Controllers\UserController::class, 'firma_sec'])->name("firma_sec");

    /// malzeme işlemleri
    Route::get('malzemeler', [App\Http\Controllers\MalzemelerController::class, 'index'])->name('malzemeler'); // Malzeme Listesi
    Route::get('malzemeler/fotograf', [App\Http\Controllers\MalzemelerController::class, 'fotograf'])->name('malzemeler.fotograf'); // Malzeme Listesi



    Route::middleware([LogoTokenKontrol::class])->group(function () {
        // Token Gerektiren işlemler Middleware Gereklidir
        // satın alma işlemleri
        Route::get('satinalma/siparis', [App\Http\Controllers\SatinAlmaController::class, 'siparis'])->name('satinalma.siparis');
        Route::get('satinalma/siparis_olustur', [App\Http\Controllers\SatinAlmaController::class, 'siparis_olustur'])->name('satinalma.siparis_olustur');
        Route::get('satinalma/siparis_duzenle/{id}', [App\Http\Controllers\SatinAlmaController::class, 'siparis_duzenle'])->name('satinalma.siparis_duzenle');
        Route::get('satinalma/irsaliye', [App\Http\Controllers\SatinAlmaController::class, 'irsaliye'])->name('satinalma.irsaliye');
        Route::get('satinalma/fatura', [App\Http\Controllers\SatinAlmaController::class, 'fatura'])->name('satinalma.fatura');
        Route::get('satinalma/onay', [App\Http\Controllers\SatinAlmaController::class, 'onay'])->name('satinalma.onay');


        Route::get('malzeme/talep_listesi', [App\Http\Controllers\MalzemelerController::class, 'talep_listesi'])->name('malzeme.talep_listesi');
        Route::get('malzeme/talep', [App\Http\Controllers\MalzemelerController::class, 'talep_olustur'])->name('malzeme.talep_olustur');
        Route::get('malzeme/talep_duzenle/{id}', [App\Http\Controllers\MalzemelerController::class, 'talep_duzenle'])->name('malzeme.talep_duzenle');
    });



    // Mobil Görünüm işlemleri

    Route::get('/mobile', [App\Http\Controllers\HomeController::class, 'mobile'])->name('mobile');
    Route::get('/mobile/malzeme/talep_olustur', [App\Http\Controllers\HomeController::class, 'talep_olustur'])->name('mobile.malzeme.talep_olustur');
    Route::get('/mobile/malzeme/talepler', [App\Http\Controllers\HomeController::class, 'talepler'])->name('mobile.malzeme.talepler');

    Route::get('/mobile/malzeme/{sku}', [App\Http\Controllers\HomeController::class, 'malzeme_detay'])->name('mobile.malzeme.malzeme_detay');
});
