@extends('layouts.app')

@section('title', 'Edit Pelanggan')
@section('judul', 'Edit Pelanggan')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama" value="{{ $pelanggan->nama }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" value="{{ $pelanggan->no_hp }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required>{{ $pelanggan->alamat }}</textarea>
            </div>

            <button class="btn btn-success">Update</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
