<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    // GET /api/paket
    public function index()
    {
        return Paket::all();
    }

    // GET /api/paket/{id}
    public function show($id)
    {
        $data = Paket::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return $data;
    }

    // POST /api/paket
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string',
            'harga' => 'required|numeric',
            'durasi' => 'nullable|string',
        ]);

        $data = Paket::create($validated);
        return $data;
    }

    // PUT /api/paket/{id}
    public function update(Request $request, $id)
    {
        $data = Paket::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->update($request->all());
        return $data;
    }

    // DELETE /api/paket/{id}
    public function destroy($id)
    {
        $data = Paket::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
