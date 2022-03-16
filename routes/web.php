<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Kontrol;


Route::get('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/login_post', [App\Http\Controllers\LoginController::class, 'login_post'])->name('login.post');
Route::get('signout', [App\Http\Controllers\LoginController::class, 'signout'])->name('signout');

Route::middleware([Kontrol::class])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
    Route::post('profil_post', [App\Http\Controllers\UserController::class, 'profil_post'])->name('profil.post');
    Route::post('password_change', [App\Http\Controllers\UserController::class, 'password_change'])->name('profil.password_change_post');
    Route::post('user_authorizations', [App\Http\Controllers\AuthorizationsController::class, 'set_authorizations'])->name('user.authorizations.post');

    Route::get('users', [App\Http\Controllers\UserController::class, 'user_list'])->name("users");
    Route::get('user/{id}', [App\Http\Controllers\UserController::class, 'user'])->name('user');

    Route::get('malzemeler', [App\Http\Controllers\MalzemelerController::class, 'index'])->name('malzemeler'); // Malzeme Listesi


    Route::get('satinalma/siparis', [App\Http\Controllers\SatinAlmaController::class, 'siparis'])->name('satinalma.siparis');
    Route::get('satinalma/irsaliye', [App\Http\Controllers\SatinAlmaController::class, 'irsaliye'])->name('satinalma.irsaliye');
    Route::get('satinalma/fatura', [App\Http\Controllers\SatinAlmaController::class, 'fatura'])->name('satinalma.fatura');
    Route::get('satinalma/onay', [App\Http\Controllers\SatinAlmaController::class, 'onay'])->name('satinalma.onay');
});
