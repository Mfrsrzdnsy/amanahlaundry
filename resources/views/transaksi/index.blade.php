@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('judul', 'Data Transaksi')

@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Data Transaksi</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Transaksi</li>
                </ul>
            </div>

            <div class="col-auto">
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="datatable table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Invoice</th>
                            <th>Pelanggan</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Dibayar</th>
                            <th>Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($transaksi as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><b>{{ $t->kode_invoice }}</b></td>
                                <td>{{ $t->pelanggan->nama }}</td>
                                <td>{{ $t->tgl_masuk }}</td>

                                <td>
                                    <span class="badge bg-info">{{ $t->status }}</span>
                                </td>

                                <td>
                                    @if ($t->dibayar == 'Sudah')
                                        <span class="badge bg-success">Sudah</span>
                                    @else
                                        <span class="badge bg-danger">Belum</span>
                                    @endif
                                </td>

                                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>

                                <td class="text-center">

                                    <!-- Detail -->
                                    <button class="btn btn-info btn-sm btn-action" data-bs-toggle="modal"
                                        data-bs-target="#detail{{ $t->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Edit -->
                                    <a href="{{ route('transaksi.edit', $t->id) }}"
                                        class="btn btn-warning btn-sm btn-action">
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    <!-- Hapus -->
                                    <button type="button" class="btn btn-danger btn-sm btn-action"
                                        onclick="hapus({{ $t->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <form id="formHapus{{ $t->id }}"
                                        action="{{ route('transaksi.destroy', $t->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>


                                    <a href="{{ route('transaksi.whatsapp', $t->id) }}"
                                        class="btn btn-success btn-sm btn-action">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>

                                </td>

                            </tr>

                            <!-- MODAL DETAIL -->
                            <div class="modal fade" id="detail{{ $t->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Transaksi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <p><b>Kode Invoice:</b> {{ $t->kode_invoice }}</p>
                                            <p><b>Pelanggan:</b> {{ $t->pelanggan->nama }}</p>
                                            <p><b>Status:</b> {{ $t->status }}</p>
                                            <p><b>Dibayar:</b>
                                                @if ($t->dibayar == 'Sudah')
                                                    <span class="badge bg-success">Sudah</span>
                                                @else
                                                    <span class="badge bg-danger">Belum</span>
                                                @endif
                                            </p>

                                            <hr>

                                            <h6><b>Layanan yang Diambil :</b></h6>
                                            <ul class="list-group mb-3">
                                                @foreach ($t->detail as $d)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <b>{{ $d->paket->nama_paket }}</b><br>
                                                            <small>Qty: {{ $d->qty }}</small>
                                                        </div>
                                                        <span>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <h5 class="text-end">
                                                Total: <b>Rp {{ number_format($t->total, 0, ',', '.') }}</b>
                                            </h5>

                                            <hr>

                                            @if ($t->foto)
                                                <label><b>Foto Cucian :</b></label><br>
                                                <img src="{{ asset('storage/' . $t->foto) }}" class="img-thumbnail rounded"
                                                    style="max-width: 250px;">
                                            @else
                                                <p class="text-muted text-center">Tidak ada foto</p>
                                            @endif

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- END MODAL DETAIL -->
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection
