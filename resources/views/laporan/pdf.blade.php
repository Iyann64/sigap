<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kejadian</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 25px;
            border: none;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 90px;
        }

        .title-cell {
            text-align: center;
            padding-right: 90px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle {
            font-size: 14px;
            color: #555;
            margin-top: 6px;
        }

        .info {
            margin-bottom: 15px;
            font-size: 13px;
        }

        .laporan-table {
            width: 100%;
            border-collapse: collapse;
        }

        .laporan-table th,
        .laporan-table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .laporan-table th {
            background: #eeeeee;
            text-align: center;
        }

        .foto {
            width: 70px;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td width="100">
                <img
                    src="{{ public_path('/images/logo website.png') }}"
                    class="logo">
            </td>

            <td class="title-cell">
                <div class="title">
                    Laporan Kejadian SIGAP
                </div>

                <div class="subtitle">
                    Sistem Informasi Gangguan dan Pelaporan
                </div>
            </td>
        </tr>
    </table>

    <!-- INFO -->
    <div class="info">
        Total Laporan:
        <strong>{{ $laporan->count() }}</strong>
    </div>

    <!-- TABLE -->
    <table class="laporan-table">
        <thead>
            <tr>
                <th width="35">No</th>
                <th>Kronologi</th>
                <th width="120">Jenis Gangguan</th>
                <th width="90">Lokasi</th>
                <th width="120">Tanggal</th>
                <th width="90">Foto</th>
                <th width="80">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($laporan as $item)

                @php
                    $fotoPath = null;

                    if ($item->foto) {
                        $fotoPath = storage_path('app/public/' . $item->foto);
                    }
                @endphp

                <tr>

                    <td style="text-align:center;">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->kronologi }}
                    </td>

                    <td>
                        {{ $item->jenis_kejadian }}
                    </td>

                    <td>
                        {{ $item->lokasi }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_waktu)->format('d/m/Y H:i') }}
                    </td>

                    <td style="text-align:center;">

                        @if($fotoPath && file_exists($fotoPath))

                            <img
                                src="{{ $fotoPath }}"
                                class="foto">

                        @else

                            Tidak Ada Foto

                        @endif

                    </td>

                    <td style="text-align:center;">
                        Tercatat
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" style="text-align:center;">
                        Data laporan kosong
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>

</body>
</html>