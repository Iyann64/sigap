<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kejadian</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; vertical-align: top; }
        th { background: #eeeeee; }
    </style>
    <img src="{{ public_path('/images/logo website.png') }}" width="140">
</head>
<body>
    <h2>Laporan Kejadian SIGAP</h2>

    <p>Total Laporan: {{ $laporan->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kronologi</th>
                <th>Jenis Gangguan</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kronologi }}</td>
                    <td>{{ $item->jenis_kejadian }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_waktu)->format('d/m/Y H:i') }}</td>
                    <td>Tercatat</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Data laporan kosong</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
