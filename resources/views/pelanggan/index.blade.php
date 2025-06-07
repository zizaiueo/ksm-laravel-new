@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="container">

    <h1 class="mb-4">Kelola Data Pelanggan</h1>

    {{-- FORM TAMBAH PELANGGAN --}}
    <div class="card mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pelanggan.store') }}" method="POST" class="row g-3 align-items-end">
                @csrf
                <div class="col-md-4">
                    <label for="nama_plggn" class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama_plggn" name="nama_plggn" value="{{ old('nama_plggn') }}" required>
                </div>

                <div class="col-md-4">
                    <label for="alamat_plggn" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat_plggn" name="alamat_plggn" value="{{ old('alamat_plggn') }}" required>
                </div>

                <div class="col-md-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Add</button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL DATA PELANGGAN --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelanggans as $index => $pelanggan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pelanggan->nama_plggn }}</td>
                    <td>{{ $pelanggan->alamat_plggn }}</td>
                    <td>{{ $pelanggan->no_hp }}</td>
                    <td>
                        {{-- Contoh tombol edit & delete --}}
                        <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus pelanggan ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
