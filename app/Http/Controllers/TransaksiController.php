<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Paket;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('pelanggan')->orderBy('id', 'DESC')->get();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        $paket = Paket::all();

        return view('transaksi.create', compact('pelanggan', 'paket'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['kode_invoice'] = 'INV-'.time();
        $data['tgl_masuk'] = date('Y-m-d');
        $data['total'] = array_sum($request->subtotal);

        // Upload foto bila ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_cucian', 'public');
        }

        $transaksi = Transaksi::create($data);

        foreach ($request->id_paket as $i => $id_paket) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_paket' => $id_paket,
                'qty' => $request->qty[$i],
                'subtotal' => $request->subtotal[$i],
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'detail.paket'])->orderBy('id', 'DESC')->get();

        return view('transaksi.struk', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('detail.paket')->findOrFail($id);
        $pelanggan = Pelanggan::all();
        $paket = Paket::all();

        return view('transaksi.edit', compact('transaksi', 'pelanggan', 'paket'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Jika status berubah menjadi "Selesai", maka set tanggal selesai otomatis
        if ($request->status == 'Selesai' && $transaksi->tgl_selesai == null) {
            $transaksi->tgl_selesai = date('Y-m-d');
        }

        // Update data transaksi utama
        $transaksi->update([
            'id_pelanggan' => $request->id_pelanggan,
            'status' => $request->status,
            'dibayar' => $request->dibayar,
            'total' => $request->total,
            'uang_bayar' => $request->uang_bayar ?? 0,
        ]);

        // Upload foto jika diganti
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto-cucian', 'public');
            $transaksi->update(['foto' => $path]);
        }

        // Hapus detail transaksi lama
        DetailTransaksi::where('id_transaksi', $transaksi->id)->delete();

        // Simpan ulang detail transaksi baru
        foreach ($request->id_paket as $i => $id_paket) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_paket' => $id_paket,
                'qty' => $request->qty[$i],
                'subtotal' => $request->subtotal[$i],
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function kirimWa($id)
    {
        $t = Transaksi::with('pelanggan', 'detail.paket')->findOrFail($id);

        // Format tanggal selesai
        $tgl_selesai = $t->tgl_selesai ? $t->tgl_selesai : 'Belum Selesai';

        $pesan = "🧺 *AMANAH LAUNDRY*\n";
        $pesan .= "===========================\n";
        $pesan .= "📄 *Nomor Nota:* {$t->kode_invoice}\n";
        $pesan .= "👤 *Pelanggan Yth:* {$t->pelanggan->nama}\n";
        $pesan .= "📅 *Masuk:* {$t->tgl_masuk}\n";
        $pesan .= "📅 *Selesai:* {$tgl_selesai}\n";
        $pesan .= "💳 *Pembayaran:* {$t->dibayar}\n";
        $pesan .= "===========================\n";
        $pesan .= "📝 *RINCIAN PESANAN:* \n";

        foreach ($t->detail as $d) {
            if ($d->qty > 0) {
                $pesan .= "- {$d->paket->nama_paket} ({$d->qty}kg)\n  Rp ".number_format($d->subtotal, 0, ',', '.')."\n";
            }
        }

        $pesan .= "===========================\n";
        $pesan .= '💰 *TOTAL:* Rp '.number_format($t->total, 0, ',', '.')."\n";

        if ($t->uang_bayar != null) {
            $pesan .= '💵 *Bayar:* Rp '.number_format($t->uang_bayar, 0, ',', '.')."\n";
            $pesan .= '🔄 *Kembalian:* Rp '.number_format($t->kembalian, 0, ',', '.')."\n";
        }

        $pesan .= "===========================\n";
        $pesan .= '🙏 *Terima kasih telah menggunakan layanan kami!*';

        // Format nomor HP (08 -> 628)
        $hp = preg_replace('/^0/', '62', $t->pelanggan->no_hp);

        // Kirim pesan via API WhatsApp
        $response = Http::withoutVerifying()->withHeaders([
            'x-api-key' => '16355809832d5a0219a646972e8',
            'Content-Type' => 'application/json',
        ])->post('https://bot.dibo.biz.id/whatsapp/send-text', [
            'number' => $hp,
            'text' => $pesan,
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', '✅ Struk berhasil dikirim via WhatsApp!');
        } else {
            return redirect()->back()->with('error', '❌ Gagal mengirim WhatsApp!');
        }
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Hapus detail transaksi terlebih dahulu
        DetailTransaksi::where('id_transaksi', $transaksi->id)->delete();

        // Hapus foto jika ada
        if ($transaksi->foto && file_exists(storage_path('app/public/'.$transaksi->foto))) {
            unlink(storage_path('app/public/'.$transaksi->foto));
        }

        $transaksi->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}
