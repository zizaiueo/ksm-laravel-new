@extends('layouts.app')

@section('title', 'Laporan Pembayaran')

@section('content')
<div class="container mt-2">
    <h3 class="mb-4">Cetak Laporan Pembayaran</h3>

    {{-- Form Pilih Periode --}}
    <form action="{{ route('laporan.pembayaran.index') }}" method="GET" class="mb-4 d-flex align-items-center">
        <label for="periode" class="me-2">Pilih Periode:</label>
        <input type="month" name="periode" id="periode" class="form-control me-3" value="{{ $periode ?? '' }}" required>
        <button type="submit" class="btn btn-primary">Tampilkan Data</button>

        @if(!empty($periode))
            <a href="{{ route('laporan.pembayaran.cetak', ['periode' => $periode]) }}" target="_blank" class="btn btn-secondary ms-3">
                <i class="fa fa-print"></i> Cetak PDF
            </a>
        @endif
    </form>

    {{-- Tabel Daftar Pembayaran --}}
    @if($pembayarans && $pembayarans->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Periode</th>
                <th>Jml. Pemakaian</th>
                <th>Total Tagihan</th>
                <th>Status</th>
                <th>Tgl. Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayarans as $index => $pembayaran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pembayaran->pelanggan->nama_plggn ?? '-' }}</td>
                <td>{{ $pembayaran->pelanggan->alamat_plggn ?? '-' }}</td>
                <td>{{ $pembayaran->periode }}</td>
                <td>{{ $pembayaran->pemakaian?->total_pemakaian ?? '-' }}</td>
                <td>{{ number_format($pembayaran->tagihan?->jumlah_tagihan ?? 0, 0, ',', '.') }}</td>
                <td>{{ ucfirst($pembayaran->status) }}</td>
                <td>{{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') : '-' }}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
    @else
        @if(request('periode'))
            <div class="alert alert-warning">Tidak ada data pembayaran untuk periode {{ request('periode') }}.</div>
        @endif
    @endif
</div>
@endsection
