@extends('layouts.customer-app')

@section('content')
<div class="container mt-4">
    <h4>Detail Tagihan Saya</h4>

    @if($tagihans->isEmpty())
        <p>Belum ada tagihan untuk Anda.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Meter Awal</th>
                    <th>Meter Akhir</th>
                    <th>Jumlah Pemakaian (m³)</th>
                    <th>Tarif per m³</th>
                    <th>Total Tagihan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tagihans as $tagihan)
                    @php
                        $pemakaian = $pemakaians[$tagihan->periode] ?? null;
                    @endphp
                    <tr>
                        <td>{{ $tagihan->periode }}</td>
                        <td>{{ $pemakaian->meter_awal ?? '-' }}</td>
                        <td>{{ $pemakaian->meter_akhir ?? '-' }}</td>
                        <td>
                            @if ($pemakaian)
                                {{ $pemakaian->meter_akhir - $pemakaian->meter_awal }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ number_format($tagihan->tarif_per_m3, 0, ',', '.') }}</td>
                        <td>{{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    @endif
</div>
@endsection
