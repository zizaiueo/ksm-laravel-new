<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pelanggan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h3 { text-align: center; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 5px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>Laporan Data Pelanggan</h3>
    <h3>KSM Tirta Lestari Flamboyan RW 020</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggans as $index => $pelanggan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pelanggan->nama_plggn }}</td>
                <td>{{ $pelanggan->alamat_plggn }}</td>
                <td>{{ $pelanggan->no_hp ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
