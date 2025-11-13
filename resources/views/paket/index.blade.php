@extends('layouts.app')
@section('title', 'Data Paket')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Data Paket Laundry</h3>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Paket</h5>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPaket">
                <i class="fas fa-plus"></i> Tambah Paket
            </button>
        </div>

        <div class="card-body">
            <table class="table table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paket as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama_paket }}</td>
                            <td>{{ $p->jenis }}</td>
                            <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-warning btn-action" data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $p->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-danger btn-action" data-bs-toggle="modal"
                                    data-bs-target="#hapus{{ $p->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="edit{{ $p->id }}">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('paket.update', $p->id) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Edit Paket</h5>
                                        </div>
                                        <div class="modal-body">

                                            <label>Nama Paket</label>
                                            <input type="text" name="nama_paket" class="form-control"
                                                value="{{ $p->nama_paket }}" required>

                                            <label class="mt-2">Jenis</label>
                                            <select name="jenis" class="form-control" required>
                                                <option value="Kiloan" {{ $p->jenis == 'Kiloan' ? 'selected' : '' }}>
                                                    Kiloan</option>
                                                <option value="Satuan" {{ $p->jenis == 'Satuan' ? 'selected' : '' }}>
                                                    Satuan</option>
                                                <option value="Dry Clean" {{ $p->jenis == 'Dry Clean' ? 'selected' : '' }}>
                                                    Dry Clean</option>
                                            </select>

                                            <label class="mt-2">Harga</label>
                                            <input type="number" name="harga" class="form-control"
                                                value="{{ $p->harga }}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapus{{ $p->id }}">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('paket.destroy', $p->id) }}">
                                    @csrf @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <p>Hapus paket <b>{{ $p->nama_paket }}</b> ?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-danger">Hapus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahPaket">
        <div class="modal-dialog">
            <form action="{{ route('paket.store') }}" method="POST"> {{-- WAJIB ADA --}}
                @csrf {{-- WAJIB ADA --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Paket</h5>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Paket</label>
                            <input type="text" name="nama_paket" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Jenis</label>
                            <select name="jenis" class="form-control" required>
                                <option value="Kiloan">Kiloan</option>
                                <option value="Satuan">Satuan</option>
                                <option value="Dry Clean">Dry Clean</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button> {{-- WAJIB TYPE SUBMIT --}}
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
