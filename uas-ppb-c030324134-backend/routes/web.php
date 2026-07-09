<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\ApiController;

Route::get('/', function () {
    return redirect('/login');
});

// Login & Logout
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route dengan Autentikasi
Route::middleware(['auth'])->group(function () {
    Route::resource('gudang', GudangController::class);

    // Route untuk Halaman Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});