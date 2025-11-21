<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// LOGIN
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// REGISTER
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// DASHBOARD (WAJIB LOGIN)
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('page.dashboard');
    })->name('dashboard');

    Route::resource('pelanggan', PelangganController::class);
    Route::resource('paket', PaketController::class);
    Route::resource('transaksi', TransaksiController::class);

    Route::get('/transaksi/{id}/struk', [TransaksiController::class, 'struk'])->name('transaksi.struk');
    Route::get('/transaksi/wa/{id}', [TransaksiController::class, 'kirimWa'])->name('transaksi.whatsapp');
});
