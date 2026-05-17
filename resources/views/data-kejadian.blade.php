@extends('layouts.sigap')

@section('title', 'Data Kejadian')

@section('content')

<div class="page-title">
    <span></span> Data Kejadian
</div>

<div class="card">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; gap:12px; flex-wrap:wrap;">
        <div class="table-meta">
            Menampilkan
            <strong>{{ $kejadian->firstItem() ?? 0 }}</strong>
            sampai
            <strong>{{ $kejadian->lastItem() ?? 0 }}</strong>
            dari
            <strong>{{ $kejadian->total() ?? 0 }}</strong>
            data
        </div>
        <div style="display:flex; gap:10px; align-items:center;">
            <form method="GET" action="{{ route('data-kejadian') }}" style="display:flex; gap:8px;">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control" style="width:200px"
                    placeholder="Cari kejadian...">
                <button type="submit" class="btn btn-primary" style="padding:8px 16px;">Cari</button>
            </form>
            <a href="{{ route('input') }}" class="btn btn-primary" style="padding:8px 16px; white-space:nowrap;">
                Tambah
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
                <td>{{ $item->tanggal_waktu->format('d/m/Y') }}</td>
                <td>{{ $item->jenis_kejadian }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>
                    <span class="badge {{ $item->badge_class }}">
                        {{ $item->regu }}
                    </span>
                </td>
                <td style="text-align:center">
                    <a href="{{ route('data-kejadian.show', $item) }}"
                       style="color:var(--blue-main); font-size:12px; font-weight:700; text-decoration:none; margin-right:8px;">Detail</a>
                    @if(auth()->user()->isAdmin())
                    <form action="{{ route('data-kejadian.destroy', $item) }}" method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Hapus data ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="background:none; border:none; color:#e53935; font-size:12px; font-weight:700; cursor:pointer;">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:var(--text-light); padding:24px;">
                    Tidak ada data kejadian.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(isset($kejadian) && $kejadian->hasPages())
    <div class="pagination">
        @if($kejadian->onFirstPage())
            <span>&lt;</span>
        @else
            <a href="{{ $kejadian->previousPageUrl() }}">&lt;</a>
        @endif

        @for($p = 1; $p <= $kejadian->lastPage(); $p++)
            @if($p == $kejadian->currentPage())
                <span class="active">{{ $p }}</span>
            @else
                <a href="{{ $kejadian->url($p) }}">{{ $p }}</a>
            @endif
        @endfor

        @if($kejadian->hasMorePages())
            <a href="{{ $kejadian->nextPageUrl() }}">&gt;</a>
            <a href="{{ $kejadian->nextPageUrl() }}" class="btn-next">Selanjutnya</a>
        @else
            <span>&gt;</span>
        @endif
    </div>
    @endif
</div>

@endsection
