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
                <label>Jenis Gangguan <span class="req">*</span></label>

                <select name="jenis_kejadian"
                        id="jenisGangguanSelect"
                        class="form-control"
                        required>

                    <option value="">-- Pilih Jenis Gangguan --</option>

                    <option value="Kebakaran" {{ old('jenis_kejadian') == 'Kebakaran' ? 'selected' : '' }}>Kebakaran</option>

                    <option value="Kebakaran Hutan" {{ old('jenis_kejadian') == 'Kebakaran Hutan' ? 'selected' : '' }}>Kebakaran Hutan</option>

                    <option value="Hujan Deras" {{ old('jenis_kejadian') == 'Hujan Deras' ? 'selected' : '' }}>Hujan Deras</option>

                    <option value="Hujan Lebat" {{ old('jenis_kejadian') == 'Hujan Lebat' ? 'selected' : '' }}>Hujan Lebat</option>

                    <option value="Kabut Tebal" {{ old('jenis_kejadian') == 'Kabut Tebal' ? 'selected' : '' }}>Kabut Tebal</option>

                    <option value="Animal Hazard" {{ old('jenis_kejadian') == 'Animal Hazard' ? 'selected' : '' }}>Animal Hazard</option>

                    <option value="Wildlife Hazard" {{ old('jenis_kejadian') == 'Wildlife Hazard' ? 'selected' : '' }}>Wildlife Hazard</option>

                    <option value="Bird Strike" {{ old('jenis_kejadian') == 'Bird Strike' ? 'selected' : '' }}>Bird Strike</option>

                    <option value="Medis Gawat Darurat" {{ old('jenis_kejadian') == 'Medis Gawat Darurat' ? 'selected' : '' }}>Medis Gawat Darurat</option>

                    <option value="FOD" {{ old('jenis_kejadian') == 'FOD' ? 'selected' : '' }}>FOD</option>

                    <option value="Runway Incursion" {{ old('jenis_kejadian') == 'Runway Incursion' ? 'selected' : '' }}>Runway Incursion</option>

                    <option value="Runway Excursion" {{ old('jenis_kejadian') == 'Runway Excursion' ? 'selected' : '' }}>Runway Excursion</option>

                    <option value="Ground Collision" {{ old('jenis_kejadian') == 'Ground Collision' ? 'selected' : '' }}>Ground Collision</option>

                    <option value="Lain Lain" {{ old('jenis_kejadian') == 'Lain Lain' ? 'selected' : '' }}>Lain Lain</option>
                </select>

                <div id="customJenisGangguanGroup"
                    style="display:none; margin-top:10px;">

                    <input type="text"
                        name="custom_jenis_gangguan"
                        id="customJenisGangguan"
                        class="form-control"
                        placeholder="Masukkan jenis gangguan lainnya">
                </div>

                @error('jenis_kejadian')
                    <span class="form-hint" style="color:#e53935">
                        {{ $message }}
                    </span>
                @enderror
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
                    <td>{{ $loop->iteration }}</td>
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
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectJenis = document.getElementById('jenisGangguanSelect');
    const customGroup = document.getElementById('customJenisGangguanGroup');
    const customInput = document.getElementById('customJenisGangguan');

    function cekLainLain() {
        if (selectJenis.value === 'Lain Lain') {
            customGroup.style.display = 'block';
            customInput.required = true;
            customInput.focus();
        } else {
            customGroup.style.display = 'none';
            customInput.required = false;
            customInput.value = '';
        }
    }

    cekLainLain();
    selectJenis.addEventListener('change', cekLainLain);
});
</script>
@endpush
@endsection