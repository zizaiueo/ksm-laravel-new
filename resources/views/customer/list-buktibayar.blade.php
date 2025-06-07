@extends('layouts.customer-app')

@section('content')

<div class="container mt-4">
    <h4>Cetak Bukti Pembayaran</h4>

    @if($pembayarans->isEmpty())
        <p>Belum ada riwayat pembayaran untuk dicetak.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Periode</th>
                    <th>Jumlah Tagihan</th>
                    <th>Status</th>
                    <th>Tanggal Bayar</th>
                    <th>Metode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembayarans as $p)
                    <tr>
                        <td>{{ $p->pelanggan->nama_plggn }}</td>
                        <td>{{ $p->periode }}</td>
                        <td>Rp {{ number_format($p->tagihan->jumlah_tagihan ?? 0, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $p->status === 'lunas' ? 'success' : 'warning' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>{{ $p->tanggal_bayar ? \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y') : '-' }}</td>
                        <td>
                            {{ $p->metode ? ucfirst($p->metode) : '-' }}
                        </td>
                        <td>
                            @if ($p->status === 'lunas')
                                <a href="{{ route('customer.cetak-buktibayar', $p->id) }}" class="btn btn-primary" target="_blank">Cetak</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada riwayat pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</div>
@endsection
