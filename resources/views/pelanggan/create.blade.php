@extends('layouts.app')
@section('title', 'Tambah Transaksi')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Tambah Transaksi</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Pelanggan</label>
                    <select name="id_pelanggan" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($pelanggan as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>

                <table class="table table-bordered" id="tabelTransaksi">
                    <thead>
                        <tr>
                            <th>Paket</th>
                            <th>Qty (Kg)</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                <select name="id_paket[]" class="form-control paketSelect" required>
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($paket as $pk)
                                        <option value="{{ $pk->id }}" data-harga="{{ $pk->harga }}">
                                            {{ $pk->nama_paket }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td><input type="number" name="qty[]" class="form-control qty" min="1" value="1">
                            </td>

                            <td><input type="text" class="form-control harga" readonly></td>

                            <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>

                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" id="addRow" class="btn btn-success btn-sm mb-3">+ Tambah Baris</button>

                <h4>Total: <span id="totalText">Rp 0</span></h4>
                <input type="hidden" name="total" id="total">

                <div class="mb-3">
                    <label>Foto Cucian (Opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>


                <div class="mt-3">
                    <button type="submit" class="btn btn-primary w-100">SIMPAN TRANSAKSI</button>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function hitung() {
            let total = 0;
            $('#tabelTransaksi tbody tr').each(function() {
                let qty = $(this).find('.qty').val();
                let harga = $(this).find('.paketSelect option:selected').data('harga') || 0;
                let subtotal = qty * harga;
                $(this).find('.harga').val(harga);
                $(this).find('.subtotal').val(subtotal);
                total += subtotal;
            });
            $('#total').val(total);
            $('#totalText').text('Rp ' + total.toLocaleString());
        }

        $('#addRow').click(function() {
            $('#tabelTransaksi tbody').append($('#tabelTransaksi tbody tr:first').clone());
        });

        $(document).on('change keyup', '.qty, .paketSelect', function() {
            hitung();
        });

        $(document).on('click', '.removeRow', function() {
            if ($('#tabelTransaksi tbody tr').length > 1) {
                $(this).closest('tr').remove();
                hitung();
            }
        });

        hitung();
    </script>
@endsection
