<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // GET /api/pelanggan
    public function index()
    {
        return Pelanggan::all();
    }

    // GET /api/pelanggan/{id}
    public function show($id)
    {
        $data = Pelanggan::find($id);

        if (! $data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return $data;
    }

    // POST /api/pelanggan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'nullable|string',
        ]);

        $data = Pelanggan::create($validated);

        return $data;
    }

    // PUT /api/pelanggan/{id}
    public function update(Request $request, $id)
    {
        $data = Pelanggan::find($id);

        if (! $data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->update($request->all());

        return $data;
    }

    // DELETE /api/pelanggan/{id}
    public function destroy($id)
    {
        $data = Pelanggan::find($id);

        if (! $data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
