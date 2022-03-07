<?php

use Illuminate\Support\Facades\Route;


Route::get('/logo/{table}', [App\Http\Controllers\Logo::class, 'index'])->name('index');
Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::get('/signout', [App\Http\Controllers\LoginController::class, 'signout'])->name('signout');




Route::get('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/login_post', [App\Http\Controllers\LoginController::class, 'login_post'])->name('login.post');
