@extends('layouts.sigap')

@section('title', 'Detail Kejadian')

@section('content')

<div class="page-title">
    <span></span> Detail Kejadian
</div>

<div style="display:grid; grid-template-columns: 1fr 340px; gap:20px; align-items:start;">

    {{-- ══ LEFT: Info Utama ══ --}}
    <div>
        <div class="card">
            <div class="card-title">Informasi Kejadian</div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px;">

                <div>
                    <div style="font-size:11.5px; color:var(--text-light); font-weight:700; margin-bottom:4px; letter-spacing:.4px">JENIS KEJADIAN</div>
                    <div style="font-size:15px; font-weight:700; color:var(--text-dark)">{{ $kejadian->jenis_kejadian }}</div>
                </div>

                <div>
                    <div style="font-size:11.5px; color:var(--text-light); font-weight:700; margin-bottom:4px; letter-spacing:.4px">LOKASI</div>
                    <div style="font-size:15px; font-weight:700; color:var(--text-dark)">{{ $kejadian->lokasi }}</div>
                </div>

                <div>
                    <div style="font-size:11.5px; color:var(--text-light); font-weight:700; margin-bottom:4px; letter-spacing:.4px">TANGGAL</div>
                    <div style="font-size:15px; font-weight:700; color:var(--text-dark)">{{ $kejadian->tanggal_format }}</div>
                </div>

                <div>
                    <div style="font-size:11.5px; color:var(--text-light); font-weight:700; margin-bottom:4px; letter-spacing:.4px">WAKTU</div>
                    <div style="font-size:15px; font-weight:700; color:var(--text-dark)">{{ $kejadian->waktu_format }} WIB</div>
                </div>

                <div style="grid-column:span 2">
                    <div style="font-size:11.5px; color:var(--text-light); font-weight:700; margin-bottom:8px; letter-spacing:.4px">KRONOLOGI KEJADIAN</div>
                    <div style="font-size:13.5px; line-height:1.7; color:var(--text-dark); background:var(--bg); padding:14px 16px; border-radius:8px; border-left:3px solid var(--orange)">
                        {{ $kejadian->kronologi }}
                    </div>
                </div>

            </div>
        </div>

        {{-- Foto Dokumentasi --}}
        @if($kejadian->foto_url)
        <div class="card">
            <div class="card-title">Foto Dokumentasi</div>
            <img src="{{ $kejadian->foto_url }}" alt="Foto Kejadian"
                 style="width:100%; border-radius:8px; object-fit:cover; max-height:320px;">
        </div>
        @else
        <div class="card" style="text-align:center; padding:32px; color:var(--text-light);">
            <div style="font-size:40px; margin-bottom:10px;">📷</div>
            <div style="font-size:13px; font-weight:600">Tidak ada foto dokumentasi</div>
        </div>
        @endif
    </div>

    {{-- ══ RIGHT: Info Petugas ══ --}}
    <div>
        <div class="card">
            <div class="card-title">Informasi Petugas</div>
            <div style="display:flex; flex-direction:column; gap:16px;">

                <div>
                    <div style="font-size:11.5px; color:var(--text-light); font-weight:700; margin-bottom:6px; letter-spacing:.4px">NAMA PERSONEL</div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="width:38px; height:38px; border-radius:50%; background:var(--blue-main); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:15px; flex-shrink:0">
                            {{ strtoupper(substr($kejadian->nama_personel, 0, 1)) }}
                        </div>
                        <div style="font-size:14px; font-weight:700; color:var(--text-dark)">{{ $kejadian->nama_personel }}</div>
                    </div>
                </div>

                <div style="height:1px; background:var(--border)"></div>

                <div>
                    <div style="font-size:11.5px; color:var(--text-light); font-weight:700; margin-bottom:6px; letter-spacing:.4px">REGU</div>
                    <span class="badge {{ $kejadian->badge_class }}" style="font-size:13px; padding:5px 14px">
                        {{ $kejadian->regu }}
                    </span>
                </div>

                <div>
                    <div style="font-size:11.5px; color:var(--text-light); font-weight:700; margin-bottom:6px; letter-spacing:.4px">SHIFT</div>
                    <div style="font-size:14px; font-weight:700; color:var(--text-dark)">{{ $kejadian->shift }}</div>
                </div>

                <div style="height:1px; background:var(--border)"></div>

                <div>
                    <div style="font-size:11.5px; color:var(--text-light); font-weight:700; margin-bottom:6px; letter-spacing:.4px">DICATAT PADA</div>
                    <div style="font-size:13px; color:var(--text-mid)">
                        {{ $kejadian->created_at->format('d/m/Y H:i') }} WIB
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="{{ route('data-kejadian') }}" class="btn btn-secondary" style="justify-content:center">
                ← Kembali ke Daftar
            </a>
            <form action="{{ route('data-kejadian.destroy', $kejadian->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn"
                    style="width:100%; justify-content:center; background:#fee2e2; color:#e53935; border:1.5px solid #fecaca;">
                    🗑️ Hapus Data Ini
                </button>
            </form>
        </div>
    </div>

</div>

@endsection