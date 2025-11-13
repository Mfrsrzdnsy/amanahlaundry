<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $paket = Paket::all();

        return view('paket.index', compact('paket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
        ]);

        Paket::create($request->all());

        return back()->with('success', 'Paket berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => 'required',
            'jenis' => 'required',
            'harga' => 'required|numeric',
        ]);

        Paket::where('id', $id)->update([
            'nama_paket' => $request->nama_paket,
            'jenis' => $request->jenis,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy($id)
    {
        Paket::findOrFail($id)->delete();

        return back()->with('success', 'Paket berhasil dihapus');
    }
}
