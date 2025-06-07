<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran - {{ $periode ?? 'Semua Periode' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 1rem;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .status-lunas {
            color: green;
            font-weight: bold;
        }
        .status-batal {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h3>Laporan Pembayaran Tagihan untuk Periode: {{ $periode ?? 'Semua Periode' }}</h3>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Periode</th>
                <th>Total Tagihan</th>
                <th>Status Pembayaran</th>
                <th>Tgl. Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayarans as $index => $pembayaran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pembayaran->pelanggan->nama_plggn ?? 'Unknown' }}</td>
                <td>{{ $pembayaran->pelanggan->alamat_plggn ?? '-' }}</td>
                <td>{{ $pembayaran->periode }}</td>
                <td class="text-right">
                    {{ number_format($pembayaran->tagihan?->jumlah_tagihan ?? 0, 0, ',', '.') }}
                </td>
                <td class="text-center">
                    @php
                        $statusClass = '';
                        if ($pembayaran->status === 'lunas') {
                            $statusClass = 'status-lunas';
                        } elseif ($pembayaran->status === 'pending') {
                            $statusClass = 'status-pending';
                        } elseif ($pembayaran->status === 'batal') {
                            $statusClass = 'status-batal';
                        }
                    @endphp
                    <span class="{{ $statusClass }}">{{ ucfirst($pembayaran->status) }}</span>
                </td>
                <td class="text-center">
                    {{ $pembayaran->tanggal_bayar ? date('d-m-Y', strtotime($pembayaran->tanggal_bayar)) : '-' }}
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;">Tidak ada data pembayaran untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <small>Dicetak tanggal: {{ date('d-m-Y H:i') }}</small>
    </div>
</body>
</html>
