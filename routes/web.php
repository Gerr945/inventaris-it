<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokMasukController;

/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Link dari Email
|--------------------------------------------------------------------------
*/

Route::get('/email/peminjaman/{id}', function ($id) {

    if (!session()->has('login')) {

        session([
            'redirect_after_login' => "/peminjaman/$id"
        ]);

        return redirect()->route('login');
    }

    return redirect("/peminjaman/$id");

})->name('email.peminjaman');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.custom', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/admin/users/{id}/history', [UserController::class, 'history'])
        ->name('users.history');

    /*
    |--------------------------------------------------------------------------
    | Master Barang
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/barang/export', [BarangController::class, 'export'])
        ->name('barang.export');

    Route::resource('barang', BarangController::class);

    /*
    |--------------------------------------------------------------------------
    | Aktif dan Nonaktif Barang
    |--------------------------------------------------------------------------
    */

    Route::patch('/barang/{id}/toggle-status', [BarangController::class, 'toggleStatus'])
        ->name('barang.toggle-status');

    /*
    |--------------------------------------------------------------------------
    | Master User
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class)
        ->except('show');
        
    Route::get('/users/export', [UserController::class, 'export'])
        ->name('users.export');

    /*
    |--------------------------------------------------------------------------
    | Peminjaman
    |--------------------------------------------------------------------------
    */

    Route::get('/peminjaman', [PeminjamanController::class, 'adminIndex'])
        ->name('admin.peminjaman');

    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
        ->name('admin.peminjaman.show');

    Route::patch('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])
        ->name('admin.peminjaman.approve');

    Route::patch('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])
        ->name('admin.peminjaman.reject');

    Route::get('/admin/peminjaman/export', [PeminjamanController::class, 'export'])
        ->name('peminjaman.export');
        
    /*
    |--------------------------------------------------------------------------
    | Stok Masuk
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/stok-masuk/riwayat/{id}', [StokMasukController::class, 'history'])
        ->name('admin.stok-masuk.history');

    Route::get('/admin/stok-masuk/{id}', [StokMasukController::class, 'create'])
        ->name('admin.stok-masuk.create');

    Route::post('/admin/stok-masuk/{id}', [StokMasukController::class, 'store'])
        ->name('admin.stok-masuk.store');

    /*
    |--------------------------------------------------------------------------
    | Pengembalian
    |--------------------------------------------------------------------------
    */

    Route::get('/pengembalian', [PengembalianController::class, 'adminIndex'])
        ->name('admin.pengembalian');

    Route::post('/pengembalian/manual/{id}', [PengembalianController::class, 'manual'])
        ->name('admin.pengembalian.manual');
    Route::get('/admin/pengembalian/export', [PengembalianController::class, 'export'])
        ->name('pengembalian.export');

});


/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.custom', 'user'])->group(function () {

    Route::get('/user/dashboard', [DashboardUserController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/user/peminjaman', [PeminjamanController::class, 'index'])
        ->name('user.peminjaman');

    Route::post('/user/peminjaman', [PeminjamanController::class, 'store'])
        ->name('user.peminjaman.store');

    Route::get('/user/pesan-admin', [App\Http\Controllers\PesanController::class, 'index'])
        ->name('user.pesan');

    Route::get('/user/riwayat', [RiwayatController::class, 'index'])
        ->name('user.riwayat');

});