@extends('layouts.app')

@section('title', 'Kelola Pemakaian Air')

@section('content')
<div class="container mt-4">
    <h2>Kelola Pemakaian Air</h2>

    {{-- Form Pilih Periode --}}
    <form action="{{ route('pemakaian.index') }}" method="GET" class="mb-4 d-flex align-items-center">
        <label for="periode" class="me-2">Pilih Periode:</label>
        
        <input type="month" name="periode" id="periode" class="form-control me-3"
            value="{{ $periode ?? '' }}" required {{ $editMode ? 'readonly disabled' : '' }}>

        @if(!$editMode)
            <button type="submit" class="btn btn-primary me-2">Tampilkan Data</button>
        @endif

        @if($periode && !$editMode)
            <a href="{{ route('pemakaian.index', ['periode' => $periode, 'edit' => 1]) }}" class="btn btn-secondary">Edit</a>
        @endif
    </form>

    {{-- Jika periode sudah dipilih, tampilkan tabel pemakaian --}}
    @if($periode)
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('pemakaian.save') }}">
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
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        @php
                            $pelanggan = $item['pelanggan'];
                            $pmk = $item['pemakaian'];

                            $meter_awal = old("pemakaian.{$pelanggan->id}.meter_awal", $pmk->meter_awal ?? 0);
                            $meter_akhir = old("pemakaian.{$pelanggan->id}.meter_akhir", $pmk->meter_akhir);

                            $total_pemakaian = ($meter_akhir !== null && $meter_akhir !== '') ? max(0, $meter_akhir - $meter_awal) : 0;
                        @endphp
                        <tr>
                            <td>{{ $pelanggan->nama_plggn }}</td>
                            <td>{{ $pelanggan->alamat_plggn }}</td>
                            <td>
                                @if($editMode)
                                    <input type="number" min="0" class="form-control" name="pemakaian[{{ $pelanggan->id }}][meter_awal]" value="{{ $meter_awal }}" required>
                                @else
                                    {{ $meter_awal }}
                                @endif
                            </td>
                            <td>
                                @if($editMode)
                                    <input type="number" min="{{ $meter_awal }}" class="form-control" name="pemakaian[{{ $pelanggan->id }}][meter_akhir]" value="{{ $meter_akhir }}">
                                @else
                                    {{ $meter_akhir !== null ? $meter_akhir : '-' }}
                                @endif
                            </td>
                            <td>{{ $total_pemakaian }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($editMode)
                <button type="submit" class="btn btn-primary">Save All</button>
                <a href="{{ route('pemakaian.index', ['periode' => $periode]) }}" class="btn btn-secondary">Batal</a>
            @endif
        </form>
    @endif
</div>
@endsection
