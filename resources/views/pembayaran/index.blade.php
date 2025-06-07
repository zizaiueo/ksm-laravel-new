@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kelola Pembayaran Tagihan</h2>

    {{-- Form Pilih Periode --}}
    <form action="{{ route('pembayaran.index') }}" method="GET" class="mb-4 d-flex align-items-center">
        <label for="periode" class="me-2">Pilih Periode:</label>
        <input type="month" name="periode" id="periode" class="form-control me-3"
            value="{{ $periode ?? '' }}" required {{ $editMode ? 'readonly disabled' : '' }}>
        @if(!$editMode)
            <button type="submit" class="btn btn-primary me-2">Tampilkan Data</button>
        @endif
        @if($periode && !$editMode)
            <a href="{{ route('pembayaran.index', ['periode' => $periode, 'edit' => 1]) }}" class="btn btn-secondary">Edit</a>
        @endif
    </form>

    {{-- Tampilkan Data Pembayaran --}}
    @if($periode)
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($data->isEmpty())
            <div class="alert alert-warning">
                Belum ada data pembayaran untuk periode <strong>{{ $periode }}</strong>.
            </div>
            <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
        @else
            <form action="{{ route('pembayaran.update') }}" method="POST">
                @csrf
                <input type="hidden" name="periode" value="{{ $periode }}">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Meter Awal</th>
                            <th>Meter Akhir</th>
                            <th>Jml. Pemakaian</th>
                            <th>Metode</th>
                            <th>Transaksi SN</th>
                            <th>Total Tagihan</th>
                            <th>Status</th>
                            <th>Tgl. Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row['pelanggan']->nama_plggn }}</td>
                                <td>{{ $row['pelanggan']->alamat_plggn }}</td>
                                <td>{{ $row['pemakaian']->meter_awal ?? '-' }}</td>
                                <td>{{ $row['pemakaian']->meter_akhir ?? '-' }}</td>
                                <td>{{ $row['pemakaian']->total_pemakaian ?? 0 }}</td>
                                <td>
                                    {{-- Tampilkan metode pembayaran sebagai teks biasa --}}
                                    {{ $row['pembayaran'] && $row['pembayaran']->metode ? ucfirst($row['pembayaran']->metode) : '-' }}

                                    {{-- Input hidden supaya data metode tetap terkirim saat form submit --}}
                                    <input type="hidden" name="pembayarans[{{ $row['pelanggan']->id }}][metode]"
                                        value="{{ $row['pembayaran'] ? $row['pembayaran']->metode : '-' }}">
                                </td>
                                <td>
                                    {{ $row['pembayaran']->transaksi_sn ?? '-' }}
                                    @if($editMode)
                                        <input type="hidden" name="pembayarans[{{ $row['pelanggan']->id }}][transaksi_sn]"
                                            value="{{ $row['pembayaran']->transaksi_sn ?? '' }}">
                                    @endif
                                </td>
                                <td>
                                    {{ isset($row['tagihan']) ? number_format($row['tagihan']->jumlah_tagihan, 0, ',', '.') : '-' }}
                                </td>

                                <td>
                                    @if($editMode)
                                        <select name="pembayarans[{{ $row['pelanggan']->id }}][status]" class="form-control">
                                            <option value="pending" {{ optional($row['pembayaran'])->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="lunas" {{ optional($row['pembayaran'])->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                        </select>
                                    @else
                                        {{ $row['pembayaran']->status ?? '-' }}
                                    @endif
                                </td>

                                <td>
                                    @if($editMode)
                                        <input type="date" name="pembayarans[{{ $row['pelanggan']->id }}][tanggal_bayar]"
                                            class="form-control"
                                            value="{{ optional($row['pembayaran'])->tanggal_bayar }}">
                                    @else
                                        {{ $row['pembayaran']->tanggal_bayar ?? '-' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($editMode)
                    <button type="submit" class="btn btn-primary">Save All</button>
                    <a href="{{ route('pembayaran.index', ['periode' => $periode]) }}" class="btn btn-secondary">Batal</a>
                @endif
            </form>
        @endif
    @endif
</div>
@endsection
