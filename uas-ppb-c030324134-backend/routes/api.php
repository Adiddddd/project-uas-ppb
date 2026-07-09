<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    // Rute untuk GET (Ambil Data)
    Route::get('/gudang', [ApiController::class, 'getGudang']);
    Route::get('/profile', [ApiController::class, 'getProfile']);
    Route::get('/jenis-gudang', [ApiController::class, 'getJenisGudang']);

    // Rute Baru untuk CRUD (Simpan, Edit, Hapus)
    Route::post('/gudang', [ApiController::class, 'storeGudang']);
    Route::put('/gudang/{id}', [ApiController::class, 'updateGudang']);
    Route::delete('/gudang/{id}', [ApiController::class, 'deleteGudang']);
});