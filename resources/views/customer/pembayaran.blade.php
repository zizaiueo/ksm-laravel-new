@extends('layouts.customer-app')

@section('content')
<div class="container mt-4">
    <h4>Pembayaran Tagihan Saya</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($tagihans->isEmpty())
        <p>Belum ada tagihan untuk dibayar.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Meter Awal</th>
                    <th>Meter Akhir</th>
                    <th>Total Pemakaian</th>
                    <th>Jumlah Tagihan</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tagihans as $tagihan)
                    <tr>
                        <td>{{ $tagihan->periode }}</td>
                        <td>{{ $tagihan->pemakaian->meter_awal ?? '-' }}</td>
                        <td>{{ $tagihan->pemakaian->meter_akhir ?? '-' }}</td>
                        <td>{{ ($tagihan->pemakaian->meter_akhir ?? 0) - ($tagihan->pemakaian->meter_awal ?? 0) }}</td>
                        <td>{{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</td>
                        <td>{{ $tagihan->pembayaran->status ?? 'Belum Bayar' }}</td>
                        <td>{{ $tagihan->pembayaran->tanggal_bayar ?? '-' }}</td>
                        <td>
                            @if(optional($tagihan->pembayaran)->status !== 'lunas')
                                <!-- Tombol Bayar -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bayarModal{{ $tagihan->id }}">
                                    Bayar
                                </button>

                                <!-- Modal Bayar -->
                                <div class="modal fade" id="bayarModal{{ $tagihan->id }}" tabindex="-1" aria-labelledby="bayarModalLabel{{ $tagihan->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('customer.kirim', $tagihan->id) }}" method="POST" onsubmit="return validateForm{{ $tagihan->id }}()">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Pembayaran Tagihan {{ $tagihan->periode }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="metode{{ $tagihan->id }}" class="form-label">Metode Pembayaran</label>
                                                        <select class="form-select" name="metode" id="metode{{ $tagihan->id }}" onchange="toggleQris{{ $tagihan->id }}()" required>
                                                            <option value="">Pilih metode</option>
                                                            <option value="online">Online (Transfer/QRIS)</option>
                                                            <option value="offline">Offline (Bayar langsung)</option>
                                                        </select>
                                                    </div>

                                                    <div id="qrisSection{{ $tagihan->id }}" style="display: none;">
                                                        <div class="mb-3">
                                                            <label><strong>Scan QRIS</strong></label><br>
                                                            <img src="{{ asset('images/qris-1.jpg') }}" alt="QRIS Code" style="max-width: 250px;">
                                                            <p class="mt-2 mb-0"><strong>A/N: KSM TIRTA LESTARI FLAMBOYAN</strong></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="no_transaksi{{ $tagihan->id }}" class="form-label">Masukkan No. Transaksi/SN:</label>
                                                            <input type="text" class="form-control" name="no_transaksi" id="no_transaksi{{ $tagihan->id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- JS toggle QRIS -->
                                <script>
                                    function toggleQris{{ $tagihan->id }}() {
                                        const metode = document.getElementById('metode{{ $tagihan->id }}').value;
                                        const qrisSection = document.getElementById('qrisSection{{ $tagihan->id }}');
                                        qrisSection.style.display = (metode === 'online') ? 'block' : 'none';
                                    }

                                    function validateForm{{ $tagihan->id }}() {
                                        const metode = document.getElementById('metode{{ $tagihan->id }}').value;
                                        const noTransaksi = document.getElementById('no_transaksi{{ $tagihan->id }}');
                                        if (metode === 'online' && noTransaksi.value.trim() === '') {
                                            alert('Nomor Transaksi harus diisi untuk metode online.');
                                            return false;
                                        }
                                        return true;
                                    }
                                </script>
                            @else
                                <!-- Tombol Disabled -->
                                <button class="btn btn-primary btn-sm" disabled>
                                    Bayar
                                </button>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
