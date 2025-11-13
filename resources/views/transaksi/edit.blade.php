@extends('layouts.app')
@section('title', 'Edit Transaksi')

@section('content')

    <div class="card">
        <div class="card-header">
            <h5>Edit Transaksi - {{ $transaksi->kode_invoice }}</h5>
        </div>

        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="card-body">

                <div class="mb-3">
                    <label>Pelanggan</label>
                    <select name="id_pelanggan" class="form-control" required>
                        @foreach ($pelanggan as $p)
                            <option value="{{ $p->id }}" {{ $transaksi->id_pelanggan == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Foto Cucian</label> <br>
                    @if ($transaksi->foto)
                        <img src="{{ asset('storage/' . $transaksi->foto) }}" class="img-thumbnail mb-2"
                            style="max-width: 200px;">
                    @else
                        <p class="text-muted">Tidak ada foto</p>
                    @endif
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>

                <hr>

                <h6><b>Edit Layanan</b></h6>
                <table class="table table-bordered" id="paketTable">
                    <thead>
                        <tr>
                            <th>Paket</th>
                            <th>Harga</th>
                            <th>Qty (Kg)</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($transaksi->detail as $d)
                            <tr>
                                <td>
                                    <select name="id_paket[]" class="form-control paketSelect">
                                        @foreach ($paket as $pk)
                                            <option value="{{ $pk->id }}" data-harga="{{ $pk->harga }}"
                                                {{ $d->id_paket == $pk->id ? 'selected' : '' }}>
                                                {{ $pk->nama_paket }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="harga">Rp {{ number_format($d->paket->harga, 0, ',', '.') }}</td>

                                <td><input type="number" name="qty[]" class="form-control qty"
                                        value="{{ $d->qty }}" step="0.1" min="0"></td>

                                <td><input type="text" name="subtotal[]" class="form-control subtotal"
                                        value="{{ $d->subtotal }}" readonly></td>

                                <td><button type="button" class="btn btn-danger btn-sm removeRow">-</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" class="btn btn-secondary btn-sm" id="addRow">+ Tambah Paket</button>

                <h4 class="text-end mt-3">Total: <span id="totalText">Rp
                        {{ number_format($transaksi->total, 0, ',', '.') }}</span></h4>
                <input type="hidden" name="total" id="totalInput" value="{{ $transaksi->total }}">

                <hr>

                <div class="mb-3">
                    <label>Status Laundry</label>
                    <select name="status" class="form-control">
                        <option {{ $transaksi->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option {{ $transaksi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option {{ $transaksi->status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Status Pembayaran</label>
                    <select name="dibayar" class="form-control" id="dibayarSelect">
                        <option {{ $transaksi->dibayar == 'Belum' ? 'selected' : '' }}>Belum</option>
                        <option {{ $transaksi->dibayar == 'Sudah' ? 'selected' : '' }}>Sudah</option>
                    </select>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                <button class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>
    </div>

    <script>
        function updateRow(row) {
            let harga = parseInt(row.querySelector('select option:checked').dataset.harga);
            let qty = parseFloat(row.querySelector('.qty').value);
            let subtotal = harga * qty;
            row.querySelector('.subtotal').value = subtotal;
            hitungTotal();
        }

        document.querySelectorAll('.qty, .paketSelect').forEach(inp => {
            inp.addEventListener('input', () => updateRow(inp.closest('tr')));
        });

        function hitungTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(s => total += parseFloat(s.value));
            document.getElementById('totalText').innerHTML = "Rp " + total.toLocaleString('id-ID');
            document.getElementById('totalInput').value = total;
        }

        document.getElementById('addRow').addEventListener('click', () => {
            let row = document.querySelector('#paketTable tbody tr').cloneNode(true);
            row.querySelector('.qty').value = 0;
            row.querySelector('.subtotal').value = 0;
            document.querySelector('#paketTable tbody').appendChild(row);
        });

        document.addEventListener('click', e => {
            if (e.target.classList.contains('removeRow')) {
                e.target.closest('tr').remove();
                hitungTotal();
            }
        });
    </script>

@endsection
