@extends('layouts.app')

@section('title', 'Kelola Tagihan Air')

@section('content')
<div class="container mt-4">
    <h2>Kelola Tagihan Air</h2>

    {{-- Form Pilih Periode --}}
    <form action="{{ route('tagihan.index') }}" method="GET" class="mb-4 d-flex align-items-center">
        <label for="periode" class="me-2">Pilih Periode:</label>
        <input type="month" name="periode" id="periode" class="form-control me-3"
            value="{{ $periode ?? '' }}" required {{ $editMode ? 'readonly disabled' : '' }}>
        @if(!$editMode)
            <button type="submit" class="btn btn-primary me-2">Tampilkan Data</button>
        @endif
        @if($periode && !$editMode)
            <a href="{{ route('tagihan.index', ['periode' => $periode, 'edit' => 1]) }}" class="btn btn-secondary">Edit</a>
        @endif
    </form>

    {{-- Tampilkan Data Tagihan --}}
    @if($periode)
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="generateForm" action="{{ route('tagihan.generateAll') }}" method="POST">
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
                        <th>Tarif /m³</th>
                        <th>Total Tagihan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item['pelanggan']->nama_plggn }}</td>
                            <td>{{ $item['pelanggan']->alamat_plggn }}</td>
                            <td>{{ $item['meter_awal'] !== null ? $item['meter_awal'] : '-' }}</td>
                            <td>{{ $item['meter_akhir'] !== null ? $item['meter_akhir'] : '-' }}</td>
                            <td>
                                @if($item['meter_awal'] !== null && $item['meter_akhir'] !== null)
                                    {{ $item['meter_akhir'] - $item['meter_awal'] }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{-- Tarif selalu tampil sebagai info UI, tapi tidak disimpan sebelum generate --}}
                                {{ number_format($item['tarif'], 0, ',', '.') }}
                            </td>
                            <td>
                                {{-- Hanya tampilkan jumlah tagihan jika sudah pernah disimpan (generate) --}}
                                @if(isset($item['jumlah_tagihan']))
                                    {{ number_format($item['jumlah_tagihan'], 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            @if($editMode)
                <button id="generateBtn" type="submit" class="btn btn-primary">Generate All</button>
                <a href="{{ route('tagihan.index', ['periode' => $periode]) }}" class="btn btn-secondary">Batal</a>
            @endif
        </form>
    @endif
</div>

<script>
    document.getElementById('generateForm').addEventListener('submit', function () {
        let btn = document.getElementById('generateBtn');
        btn.disabled = true;
        btn.textContent = 'Generating...';
    });
</script>
@endsection
