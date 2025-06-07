@extends('layouts.customer-app')

@section('content')
<div class="container mt-4">
    <h2>Selamat datang, {{ $pelanggan->nama_plggn ?? 'Customer' }}</h2>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $pelanggan->nama_plggn }}</p>
            <p><strong>Alamat:</strong> {{ $pelanggan->alamat_plggn }}</p>
            <p><strong>No. HP:</strong> {{ $pelanggan->no_hp }}</p>
        </div>
    </div>
</div>
@endsection
