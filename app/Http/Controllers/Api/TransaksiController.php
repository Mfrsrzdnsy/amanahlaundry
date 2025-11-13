<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return response()->json(Transaksi::with('pelanggan', 'detail.paket')->get());
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'detail.paket')->find($id);
        if (! $transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($transaksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'total' => 'required|numeric',
            'status' => 'nullable|string',
            'dibayar' => 'nullable|string',
        ]);

        $transaksi = Transaksi::create([
            'kode_invoice' => 'INV-'.time(),
            'id_pelanggan' => $request->id_pelanggan,
            'tgl_masuk' => now(),
            'status' => $request->status ?? 'Proses',
            'dibayar' => $request->dibayar ?? 'Belum',
            'total' => $request->total,
        ]);

        return response()->json([
            'message' => 'Transaksi berhasil disimpan',
            'data' => $transaksi,
        ], 201);
    }
}
