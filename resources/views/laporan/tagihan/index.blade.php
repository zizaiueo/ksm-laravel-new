@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <h3 class="mb-4">Cetak Laporan Tagihan</h3>

    <!-- Form pilih periode -->
    <form action="{{ route('laporan.tagihan.index') }}" method="GET" class="mb-4 d-flex align-items-center">
        <label for="periode" class="me-2">Pilih Periode:</label>
        <input type="month" name="periode" id="periode" class="form-control me-3" value="{{ $periode ?? '' }}" required>
        <button type="submit" class="btn btn-primary">Tampilkan Data</button>

        @if(!empty($periode))
            <a href="{{ route('laporan.tagihan.cetak', ['periode' => $periode]) }}" target="_blank" class="btn btn-secondary ms-3">
                <i class="fa fa-print"></i> Cetak PDF
            </a>
        @endif
    </form>

    @if(!empty($tagihans) && $tagihans->count() > 0)
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Periode</th>
                <th>Meter Awal</th>
                <th>Meter Akhir</th>
                <th>Jml. Pemakaian</th>
                <th>Tarif /m³</th>
                <th>Total Tagihan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tagihans as $index => $tagihan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $tagihan->pelanggan->nama_plggn ?? 'Unknown' }}</td>
                <td>{{ $tagihan->pelanggan->alamat_plggn ?? '-' }}</td>
                <td>{{ $tagihan->periode }}</td>
                <td>{{ $tagihan->pemakaian_filtered->meter_awal ?? '-' }}</td>
                <td>{{ $tagihan->pemakaian_filtered->meter_akhir ?? '-' }}</td>
                <td>{{ $tagihan->pemakaian_filtered->total_pemakaian ?? '-' }}</td>
                <td>{{ number_format($tagihan->tarif_per_m3 ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($tagihan->jumlah_tagihan ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @elseif(!empty($periode))
        <div class="alert alert-warning">Data tagihan untuk periode <strong>{{ $periode }}</strong> tidak ditemukan.</div>
    @endif
</div>
@endsection
