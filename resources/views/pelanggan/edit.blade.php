@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
    <h1 class="mb-4">Edit Pelanggan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_plggn" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="nama_plggn" name="nama_plggn" value="{{ old('nama_plggn', $pelanggan->nama_plggn) }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat_plggn" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat_plggn" name="alamat_plggn" rows="3" required>{{ old('alamat_plggn', $pelanggan->alamat_plggn) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
