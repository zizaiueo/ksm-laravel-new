@extends('layouts.app')

@section('title', 'Laporan Pelanggan')

@section('content')
<div class="container mt-2">
    <h3>Cetak Data Pelanggan</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggans as $index => $pelanggan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pelanggan->nama_plggn }}</td>
                <td>{{ $pelanggan->alamat_plggn }}</td>
                <td>{{ $pelanggan->no_hp ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('laporan.pelanggan.cetak') }}" class="btn btn-primary" target="_blank">
        <i class="fa fa-print"></i> Cetak PDF
    </a>
</div>
@endsection
