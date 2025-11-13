<?php

use App\Http\Controllers\PaketController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('page.dashboard');
})->name('dashboard');

Route::resource('pelanggan', PelangganController::class);
Route::resource('paket', PaketController::class);
Route::resource('transaksi', TransaksiController::class);
Route::get('/transaksi/{id}/struk', [TransaksiController::class, 'struk'])->name('transaksi.struk');
Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::get('/transaksi/wa/{id}', [TransaksiController::class, 'kirimWa'])->name('transaksi.whatsapp');

Route::post('/logout', function () {
    Auth::logout();

    return redirect('/'); // kembali ke halaman login / dashboard
})->name('logout');
