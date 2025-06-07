<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        .no-border td { border: none; }
        .right { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">WATER BILLING</h2>
    <h2 style="text-align: center;">INVOICE</h2>
    <P>--------------------------------------------------------------------------------------------------------</P>

    <table class="no-border">
        <tr>
            <td>Nama</td>
            <td>: {{ $pembayaran->pelanggan->nama_plggn }}</td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td>: {{ $pembayaran->pelanggan->no_hp }}</td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>: {{ $pembayaran->periode }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td><strong>: {{ ucfirst($pembayaran->status) }}</strong></td>
        </tr>
        <tr>
            <td>Tanggal Bayar</td>
            <td>: {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Metode</td>
            <td>
                : 
                @if($pembayaran->metode === 'online' || $pembayaran->metode === 'transfer' || $pembayaran->metode === 'qris')
                    {{ ucfirst($pembayaran->metode) }}
                    @if($pembayaran->transaksi_sn)
                        (SN: {{ $pembayaran->transaksi_sn }})
                    @endif
                @elseif($pembayaran->metode === 'offline')
                    Offline
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Meter Awal</th>
                <th>Meter Akhir</th>
                <th>Jml. Pemakaian</th>
                <th>Tarif / m³</th>
                <th>Total Tagihan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $tagihan->pemakaian->meter_awal }}</td>
                <td>{{ $tagihan->pemakaian->meter_akhir }}</td>
                <td>{{ $tagihan->pemakaian->meter_akhir - $tagihan->pemakaian->meter_awal }}</td>
                <td>Rp {{ number_format($tagihan->tarif_per_m3, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="no-border">
        <tr>
            <p><small>Terimakasih telah melakukan pembayaran, harap simpan invoice ini sebagai bukti pembayaran yang sah.</small></p>
            
            <td class="right">
                <p></p>
                <p></p>
                <p></p>
                <p></p>
                <small><strong>KSM Tirta Lestari Flamboyan</strong></small>
                <small>Komplek Reni Jaya RW 020, Jl. Flamboyan VII</small><br>
            </td>
        </tr>
    </table>

</body>
</html>
