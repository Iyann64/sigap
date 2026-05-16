@extends('layouts.sigap')

@section('title', 'Data Kejadian')

@section('content')

<div class="page-title">
    <span></span> Data Kejadian
</div>

<div class="card">

    {{-- Toolbar --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; gap:12px; flex-wrap:wrap;">
        <div class="table-meta">
            Menampilkan
            <strong>{{ $kejadian->firstItem() ?? 1 }}</strong>
            sampai
            <strong>{{ $kejadian->lastItem() ?? 6 }}</strong>
            dari
            <strong>{{ $kejadian->total() ?? 50 }}</strong>
            data
        </div>
        <div style="display:flex; gap:10px; align-items:center;">
            <form method="GET" action="{{ route('data-kejadian') }}" style="display:flex; gap:8px;">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control" style="width:200px"
                    placeholder="🔍 Cari kejadian...">
                <button type="submit" class="btn btn-primary" style="padding:8px 16px;">Cari</button>
            </form>
            <a href="{{ route('input') }}" class="btn btn-primary" style="padding:8px 16px; white-space:nowrap;">
                ＋ Tambah
            </a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:48px">No.</th>
                <th>Tanggal</th>
                <th>Jenis Kejadian</th>
                <th>Lokasi</th>
                <th>Shift Jaga</th>
                <th style="width:100px; text-align:center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kejadian ?? [] as $i => $item)
            <tr>
                <td>{{ ($kejadian->currentPage() - 1) * $kejadian->perPage() + $i + 1 }}.</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_waktu)->format('d/m/Y') }}</td>
                <td>{{ $item->jenis_kejadian }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>
                    <span class="badge {{ $item->badge_class }}">
                        {{ $item->regu }}
                    </span>
                </td>
                <td style="text-align:center">
                    <a href="{{ route('data-kejadian.show', $item->id) }}"
                       style="color:var(--blue-main); font-size:12px; font-weight:700; text-decoration:none; margin-right:8px;">Detail</a>
                    <form action="{{ route('data-kejadian.destroy', $item->id) }}" method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Hapus data ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="background:none; border:none; color:#e53935; font-size:12px; font-weight:700; cursor:pointer;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            {{-- Dummy rows untuk preview --}}
            @foreach([
                ['1', '19/04/2025', 'Kebakaran Hutan', 'Luar Bandara', 'Alpha'],
                ['2', '15/04/2025', 'Hujan Deras',     'Runway',       'Alpha'],
                ['3', '03/04/2025', 'Kabut Tebal',     'Runway',       'charlie'],
                ['4', '28/03/2025', 'Bird Strike',     'Runway',       'Bravo'],
                ['5', '24/03/2025', 'Wildlife Hazard', 'Apron',        'Charlie'],
                ['6', '17/03/2025', 'Medis Gawat Darurat', 'Apron',    'Bravo'],
            ] as $row)
            <tr>
                <td>{{ $row[0] }}.</td>
                <td>{{ $row[1] }}</td>
                <td>{{ $row[2] }}</td>
                <td>{{ $row[3] }}</td>
                <td>
                    <span class="badge {{ $row[4] == 'Alpha' ? 'badge-blue' : ($row[4] == 'Bravo' ? 'badge-orange' : 'badge-green') }}">
                        {{ $row[4] }}
                    </span>
                </td>
                <td style="text-align:center">
                    <span style="color:var(--blue-main); font-size:12px; font-weight:700; margin-right:8px; cursor:pointer">Detail</span>
                    <span style="color:#e53935; font-size:12px; font-weight:700; cursor:pointer">Hapus</span>
                </td>
            </tr>
            @endforeach
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if(isset($kejadian) && $kejadian->hasPages())
    <div class="pagination">
        {{-- Previous --}}
        @if($kejadian->onFirstPage())
            <span>‹</span>
        @else
            <a href="{{ $kejadian->previousPageUrl() }}">‹</a>
        @endif

        {{-- Page numbers --}}
        @for($p = 1; $p <= $kejadian->lastPage(); $p++)
            @if($p == $kejadian->currentPage())
                <span class="active">{{ $p }}</span>
            @else
                <a href="{{ $kejadian->url($p) }}">{{ $p }}</a>
            @endif
        @endfor

        {{-- Next --}}
        @if($kejadian->hasMorePages())
            <a href="{{ $kejadian->nextPageUrl() }}">›</a>
            <a href="{{ $kejadian->nextPageUrl() }}" class="btn-next">Selanjutnya</a>
        @else
            <span>›</span>
        @endif
    </div>
    @else
    {{-- Dummy pagination preview --}}
    <div class="pagination">
        <span class="active">1</span>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">›</a>
        <a href="#" class="btn-next">Selanjutnya</a>
    </div>
    @endif

</div>

@endsection