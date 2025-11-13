<?php

use App\Http\Controllers\Api\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);
Route::post('/transaksi', [TransaksiController::class, 'store']);
