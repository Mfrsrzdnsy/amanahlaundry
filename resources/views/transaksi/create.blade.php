@extends('layouts.app')
@section('title', 'Transaksi Baru')

@section('content')

    <div class="card">
        <div class="card-header">
            <h5>Transaksi Baru</h5>
        </div>

        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">

                <div class="mb-3">
                    <label>Pelanggan</label>
                    <select name="id_pelanggan" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($pelanggan as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- FOTO CUCIAAN -->
                <div class="mb-3">
                    <label>Foto Cucian (Opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" capture="camera">
                </div>

                <table class="table table-bordered" id="tabelPaket">
                    <thead>
                        <tr>
                            <th>Paket</th>
                            <th>Harga</th>
                            <th>Qty (Kg)</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                <select name="id_paket[]" class="form-control paketSelect" required>
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($paket as $p)
                                        <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">
                                            {{ $p->nama_paket }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td><input type="text" class="form-control harga" readonly></td>

                            <td><input type="number" name="qty[]" class="form-control qty" step="0.1">
                            </td>

                            <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>

                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm tambahRow">+</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h4 class="text-end">Total: <span id="grandTotal">Rp 0</span></h4>
                <input type="hidden" name="total" id="totalInput">
                <div class="mb-3">
                    <label>Status Pembayaran</label>
                    <select name="dibayar" id="dibayarSelect" class="form-control" required>
                        <option value="Belum">Belum Dibayar</option>
                        <option value="Sudah">Sudah Dibayar</option>
                    </select>
                </div>

                <div class="mb-3" id="kembalianSection" style="display:none;">
                    <label>Kembalian</label>
                    <input type="text" id="kembalian" class="form-control" readonly>
                </div>


            </div>

            <div class="card-footer text-end">
                <button class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>

        <script>
            function hitungTotal() {
                let total = 0;
                document.querySelectorAll('#tabelPaket tbody tr').forEach((row) => {

                    let harga = parseFloat(row.querySelector('.harga').value) || 0;
                    let qty = parseFloat(row.querySelector('.qty').value) || 0;
                    let subtotalField = row.querySelector('.subtotal');

                    let subtotal = harga * qty;
                    subtotalField.value = subtotal;

                    total += subtotal;
                });

                document.getElementById('grandTotal').innerText = "Rp " + total.toLocaleString('id-ID');
                document.getElementById('totalInput').value = total;
            }

            // Update harga saat pilih paket
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('paketSelect')) {
                    let harga = e.target.options[e.target.selectedIndex].getAttribute('data-harga');
                    let row = e.target.closest('tr');
                    row.querySelector('.harga').value = harga;
                    hitungTotal();
                }
            });

            // Hitung ulang jika qty berubah
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('qty')) {
                    hitungTotal();
                }
            });

            // Tambah baris baru
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('tambahRow')) {
                    let row = e.target.closest('tr');
                    let clone = row.cloneNode(true);

                    clone.querySelectorAll('input').forEach(input => input.value = '');
                    clone.querySelector('.btn-success').classList.replace('btn-success', 'btn-danger');
                    clone.querySelector('.btn-danger').classList.replace('tambahRow', 'hapusRow');
                    clone.querySelector('.btn-danger').innerText = '-';

                    document.querySelector('#tabelPaket tbody').appendChild(clone);
                }
            });

            // Hapus baris
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('hapusRow')) {
                    e.target.closest('tr').remove();
                    hitungTotal();
                }
            });
        </script>

    </div>

    <script>
        function hitungTotal() {
            let total = 0;
            document.querySelectorAll('tbody tr').forEach((row) => {
                let harga = row.querySelector('.harga').value;
                let qty = row.querySelector('.qty').value;
                let subtotal = row.querySelector('.subtotal');

                let hasil = parseFloat(qty) * parseFloat(harga);
                subtotal.value = isNaN(hasil) ? 0 : hasil;
                total += hasil;
            });

            document.getElementById('grandTotal').innerHTML = "Rp " + total.toLocaleString('id-ID');
            document.getElementById('totalInput').value = total;
            console.log(total);

            // Jika sudah memilih pembayaran → hitung kembalian ulang otomatis
            let bayar = parseFloat(document.getElementById('uangBayar')?.value) || 0;
            if (bayar > 0) {
                let kembali = bayar - total;
                document.getElementById('kembalian').value = "Rp " + kembali.toLocaleString('id-ID');
            }
        }

        // Hitung subtotal ketika qty diubah manual
        document.querySelectorAll('.qty').forEach((input) => {
            input.addEventListener('input', hitungTotal);
        });

        document.getElementById('uangBayar')?.addEventListener('input', hitungTotal);
    </script>


@endsection
