<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/logo/{table}', [App\Http\Controllers\Logo::class, 'index'])->name('index');

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::get('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/login_post', [App\Http\Controllers\LoginController::class, 'login_post'])->name('login.post');
Route::post('/signOut', [App\Http\Controllers\LoginController::class, 'signOut'])->name('signOut');



Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
