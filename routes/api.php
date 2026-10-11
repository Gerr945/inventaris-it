<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileApiController;

Route::prefix('mobile')->group(function () {

    Route::post('/login', [
        MobileApiController::class,
        'login'
    ]);

    Route::get('/dashboard', [
        MobileApiController::class,
        'dashboard'
    ]);

    Route::get('/peminjaman', [
        MobileApiController::class,
        'peminjaman'
    ]);

    Route::post('/peminjaman', [
        MobileApiController::class,
        'storePeminjaman'
    ]);

    Route::get('/pesan', [
        MobileApiController::class,
        'pesan'
    ]);

    Route::get('/riwayat', [
        MobileApiController::class,
        'riwayat'
    ]);
});