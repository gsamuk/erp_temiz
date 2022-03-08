<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Kontrol;


Route::get('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/login_post', [App\Http\Controllers\LoginController::class, 'login_post'])->name('login.post');
Route::get('signout', [App\Http\Controllers\LoginController::class, 'signout'])->name('signout');

Route::middleware([Kontrol::class])->group(function () { /// middliware kontrolü
    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
    Route::get('profil', [App\Http\Controllers\UserController::class, 'profil'])->name('profil');
    Route::post('profil_post', [App\Http\Controllers\UserController::class, 'profil_post'])->name('profil.post');

    Route::get('users', [App\Http\Controllers\UserController::class, 'user_list']);
});
