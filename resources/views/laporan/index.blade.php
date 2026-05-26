@extends('layouts.sigap')

@section('title', 'Laporan')

@section('content')
<div class="page-title">
    <span></span> Laporan Kejadian
</div>

<div class="card">
    <div class="card-title">Filter Laporan</div>

    <form method="GET" action="{{ route('laporan.index') }}">
        <div class="form-grid">
            <div class="form-group">
                <label>Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
            </div>

            <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
            </div>

           <div class="form-group">
                <label>Jenis Gangguan</label>

                <select name="jenis_kejadian"
                        id="jenisGangguanSelect"
                        class="form-control">

                    <option value="">-- Pilih Jenis Gangguan --</option>

                    @foreach($jenisKejadianOptions ?? [] as $jenisKejadian)
                        <option value="{{ $jenisKejadian }}" {{ request('jenis_kejadian') == $jenisKejadian ? 'selected' : '' }}>
                            {{ $jenisKejadian }}
                        </option>
                    @endforeach
                </select>

                @error('jenis_kejadian')
                    <span class="form-hint" style="color:#e53935">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label>Lokasi</label>
                <select name="lokasi" class="form-control">
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach(['Runway', 'Taxiway', 'Apron', 'Terminal'] as $lokasi)
                        <option value="{{ $lokasi }}" {{ request('lokasi') == $lokasi ? 'selected' : '' }}>
                            {{ $lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>&nbsp;</label>
                <div class="form-actions" style="margin-top:0; justify-content:flex-start;">
                    <button type="submit" class="btn btn-primary">Filter</button>

                    <a href="{{ route('laporan.pdf', request()->query()) }}" class="btn btn-secondary">
                        PDF
                    </a>

                    <a href="{{ route('laporan.excel', request()->query()) }}" class="btn btn-secondary">
                        Excel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-title">Riwayat Logbook Kejadian</div>

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
                    <td>{{ $laporan->firstItem() + $loop->index }}</td>
                    <td>{{ Str::limit($item->kronologi, 50) }}</td>
                    <td>{{ $item->jenis_kejadian }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>
                        {{ $item->tanggal_waktu ? \Carbon\Carbon::parse($item->tanggal_waktu)->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td>
                        <span class="badge badge-green">Tercatat</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">
                        Data laporan kosong
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($laporan->hasPages())

    <div class="pagination-laporan">

        {{-- Previous --}}
        @if($laporan->onFirstPage())
            <span class="disabled">&lt;</span>
        @else
            <a href="{{ $laporan->previousPageUrl() }}">&lt;</a>
        @endif

        {{-- Nomor halaman --}}
        @for($page = 1; $page <= $laporan->lastPage(); $page++)

            @if($page == $laporan->currentPage())

                <span class="active">
                    {{ $page }}
                </span>

            @else

                <a href="{{ $laporan->url($page) }}">
                    {{ $page }}
                </a>

            @endif

        @endfor

        {{-- Next --}}
        @if($laporan->hasMorePages())
            <a href="{{ $laporan->nextPageUrl() }}">&gt;</a>
        @else
            <span class="disabled">&gt;</span>
        @endif

    </div>

@endif
</div>

@endsection
