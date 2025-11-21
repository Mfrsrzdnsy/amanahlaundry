<?php

use App\Http\Controllers\Api\PaketController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);
Route::post('/transaksi', [TransaksiController::class, 'store']);

Route::get('/pelanggan', [PelangganController::class, 'index']);
Route::get('/pelanggan/{id}', [PelangganController::class, 'show']);
Route::post('/pelanggan', [PelangganController::class, 'store']);
Route::put('/pelanggan/{id}', [PelangganController::class, 'update']);
Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy']);

Route::get('/paket', [PaketController::class, 'index']);
Route::get('/paket/{id}', [PaketController::class, 'show']);
Route::post('/paket', [PaketController::class, 'store']);
Route::put('/paket/{id}', [PaketController::class, 'update']);
Route::delete('/paket/{id}', [PaketController::class, 'destroy']);
