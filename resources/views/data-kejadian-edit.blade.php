@extends('layouts.sigap')
@section('title', 'Edit Laporan')
@section('content')
<div class="page-title"><span></span> Edit Laporan Kejadian</div>
<div class="card">
    <form action="{{ route('data-kejadian.update', $kejadian) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Jenis Kejadian <span class="req">*</span></label>
                @php
                    $options = [
                        'Kebakaran',
                        'Kebakaran Hutan',
                        'Hujan Deras',
                        'Hujan Lebat',
                        'Kabut Tebal',
                        'Animal Hazard',
                        'Wildlife Hazard',
                        'Bird Strike',
                        'Medis Gawat Darurat',
                        'FOD',
                        'Runway Incursion',
                        'Runway Excursion',
                        'Ground Collision',
                    ];
                    $selectedJenis = old('jenis_kejadian', in_array($kejadian->jenis_kejadian, $options, true) ? $kejadian->jenis_kejadian : 'Lain Lain');
                    $customJenis = old('custom_jenis_kejadian', in_array($kejadian->jenis_kejadian, $options, true) ? '' : $kejadian->jenis_kejadian);
                @endphp
                <select name="jenis_kejadian" id="jenisKejadianSelect" class="form-control" required>
                    <option value="">-- Pilih Jenis Kejadian --</option>
                    @foreach($options as $opt)
                        <option value="{{ $opt }}" {{ $selectedJenis == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                    <option value="Lain Lain" {{ $selectedJenis == 'Lain Lain' ? 'selected' : '' }}>Lain Lain</option>
                </select>
            </div>
            
            <div id="customJenisKejadianGroup" class="form-group" style="display:none;">
                <label>Sebutkan Jenis Kejadian <span class="req">*</span></label>
                <input type="text" name="custom_jenis_kejadian" id="customJenisKejadian" class="form-control" value="{{ $customJenis }}">
                @error('custom_jenis_kejadian')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="grid-row: span 2;">
                <label>Kronologi Kejadian <span class="req">*</span></label>
                <textarea name="kronologi" class="form-control" style="min-height:130px" required>{{ old('kronologi', $kejadian->kronologi) }}</textarea>
            </div>

            <div class="form-group">
                <label>Lokasi Kejadian <span class="req">*</span></label>
                @php
                    $lokasiOptions = ['Runway', 'Taxiway', 'Apron', 'Luar Bandara', 'Terminal', 'Hanggar'];
                    $selectedLokasi = old('lokasi', in_array($kejadian->lokasi, $lokasiOptions, true) ? $kejadian->lokasi : 'Lain Lain');
                    $customLokasi = old('custom_lokasi', in_array($kejadian->lokasi, $lokasiOptions, true) ? '' : $kejadian->lokasi);
                @endphp
                <select name="lokasi" id="lokasiSelect" class="form-control" required>
                    @foreach($lokasiOptions as $loc)
                        <option value="{{ $loc }}" {{ $selectedLokasi == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                    @endforeach
                    <option value="Lain Lain" {{ $selectedLokasi == 'Lain Lain' ? 'selected' : '' }}>Lain Lain</option>
                </select>
                <div id="customLokasiGroup" style="display:none; margin-top:10px;">
                    <input type="text" name="custom_lokasi" id="customLokasi" class="form-control" value="{{ $customLokasi }}" placeholder="Masukkan lokasi lainnya">
                </div>
                @error('custom_lokasi')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal & Waktu <span class="req">*</span></label>
                <input type="datetime-local" name="tanggal_waktu" class="form-control" value="{{ old('tanggal_waktu', $kejadian->tanggal_waktu->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="form-group">
                <label>Foto Baru (Biarkan kosong jika tidak diubah)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>Nama Personel <span class="req">*</span></label>
                <input type="text" name="nama_personel" class="form-control" value="{{ old('nama_personel', $kejadian->nama_personel) }}" required>
            </div>

            <div class="form-group">
                <label>Regu <span class="req">*</span></label>
                <select name="regu" class="form-control" required>
                    @foreach(['Alpha', 'Bravo', 'Charlie', 'Delta'] as $r)
                        <option value="{{ $r }}" {{ old('regu', $kejadian->regu) == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Shift <span class="req">*</span></label>
                <select name="shift" class="form-control" required>
                    @foreach(['Pagi', 'Siang', 'Malam'] as $s)
                        <option value="{{ $s }}" {{ old('shift', $kejadian->shift) == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('data-kejadian') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Laporan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const select = document.getElementById('jenisKejadianSelect');
    const customGroup = document.getElementById('customJenisKejadianGroup');
    const customInput = document.getElementById('customJenisKejadian');
    function checkCustom() {
        const isCustom = select.value === 'Lain Lain';
        customGroup.style.display = isCustom ? 'block' : 'none';
        if (isCustom) {
            customInput.setAttribute('required', 'required');
        } else {
            customInput.removeAttribute('required');
            customInput.value = '';
        }
    }
    select.addEventListener('change', checkCustom);
    window.onload = checkCustom;

    const lokasiSelect = document.getElementById('lokasiSelect');
    const customLokasiGroup = document.getElementById('customLokasiGroup');
    const customLokasi = document.getElementById('customLokasi');
    function checkCustomLokasi() {
        const isCustom = lokasiSelect.value === 'Lain Lain';
        customLokasiGroup.style.display = isCustom ? 'block' : 'none';
        if (isCustom) {
            customLokasi.setAttribute('required', 'required');
        } else {
            customLokasi.removeAttribute('required');
            customLokasi.value = '';
        }
    }
    lokasiSelect.addEventListener('change', checkCustomLokasi);
    checkCustomLokasi();
</script>
@endpush
