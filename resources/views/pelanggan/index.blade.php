@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('judul', 'Data Pelanggan')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Data Pelanggan</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Data Pelanggan</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Data Pelanggan</h5>

                    <!-- Tombol Tambah (Desktop) -->
                    <button class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover datatable">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Alamat</th>
                                    <th width="120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggan as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->no_hp }}</td>
                                        <td>{{ $p->alamat }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-action" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $p->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button class="btn btn-danger btn-action" data-bs-toggle="modal"
                                                data-bs-target="#modalHapus{{ $p->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('pelanggan.update', $p->id) }}">
                                                @csrf @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Pelanggan</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Nama</label>
                                                            <input type="text" name="nama" class="form-control"
                                                                value="{{ $p->nama }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>No HP</label>
                                                            <input type="text" name="no_hp" class="form-control"
                                                                value="{{ $p->no_hp }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Alamat</label>
                                                            <textarea name="alamat" class="form-control" required>{{ $p->alamat }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="modalHapus{{ $p->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('pelanggan.destroy', $p->id) }}">
                                                @csrf @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus Pelanggan</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <p>Yakin ingin menghapus <b>{{ $p->nama }}</b> ?</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-danger" type="submit">Hapus</button>
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


                <!-- Tombol Mobile Floating -->
                <a href="{{ route('pelanggan.create') }}"
                    class="btn btn-primary btn-lg rounded-circle shadow tombol-mobile">
                    <i class="fas fa-plus"></i>
                </a>

                <style>
                    /* Floating Button Mobile */
                    .tombol-mobile {
                        position: fixed;
                        bottom: 25px;
                        right: 25px;
                        display: none;
                        width: 55px;
                        height: 55px;
                        padding-top: 14px;
                        text-align: center;
                        z-index: 999;
                    }

                    /* Hanya tampil di layar kecil */
                    @media (max-width: 576px) {
                        .tombol-mobile {
                            display: block;
                        }

                        .d-sm-inline-block {
                            display: none !important;
                        }
                    }
                </style>


            @endsection

            <!-- Modal Tambah -->
            <div class="modal fade" id="modalTambah" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('pelanggan.store') }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Pelanggan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>No HP</label>
                                    <input type="text" name="no_hp" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
