<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tagihan - {{ $periode ?? 'Semua Periode' }}</title>
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
    </style>
</head>
<body>
    <h3>Laporan Tagihan Air untuk Periode: {{ $periode ?? 'Semua Periode' }}</h3>

    <table>
        <thead>
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
            @forelse($tagihans as $index => $tagihan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $tagihan->pelanggan->nama_plggn ?? 'Unknown' }}</td>
                <td>{{ $tagihan->pelanggan->alamat_plggn ?? '-' }}</td>
                <td>{{ $tagihan->periode }}</td>
                <td>{{ $tagihan->pemakaian_filtered->meter_awal ?? '-' }}</td>
                <td>{{ $tagihan->pemakaian_filtered->meter_akhir ?? '-' }}</td>
                <td class="text-right">{{ $tagihan->pemakaian_filtered->total_pemakaian ?? '-' }}</td>
                <td class="text-right">{{ number_format($tagihan->tarif_per_m3 ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($tagihan->jumlah_tagihan ?? 0, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;">Tidak ada data tagihan untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <small>Dicetak tanggal: {{ date('d-m-Y H:i') }}</small>
    </div>
</body>
</html>
