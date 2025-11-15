<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// === HALAMAN LOGIN SAAT AKSES "/" ===
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// === LOGIN PROCESS ===
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// === LOGOUT ===
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// === DASHBOARD (HARUS LOGIN) ===
Route::get('/dashboard', function () {
    return view('page.dashboard');
})->middleware('auth')->name('dashboard');

// === RESOURCE CONTROLLERS (HARUS LOGIN) ===
Route::middleware('auth')->group(function () {

    Route::resource('pelanggan', PelangganController::class);
    Route::resource('paket', PaketController::class);
    Route::resource('transaksi', TransaksiController::class);

    Route::get('/transaksi/{id}/struk', [TransaksiController::class, 'struk'])->name('transaksi.struk');
    Route::get('/transaksi/wa/{id}', [TransaksiController::class, 'kirimWa'])->name('transaksi.whatsapp');
});
