@extends('layouts.sigap')

@section('title', 'Input Laporan')

@section('content')

<div class="page-title">
    <span></span> Input Laporan Kejadian
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-error">Terdapat kesalahan pada form. Silakan periksa kembali.</div>
@endif

<div class="card">
    <form action="{{ route('input.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Jenis Kejadian <span class="req">*</span></label>
                <select name="jenis_kejadian" class="form-control" required>
                    <option value="">-- Pilih Jenis Kejadian --</option>
                    <option value="Kebakaran" {{ old('jenis_kejadian') == 'Kebakaran' ? 'selected' : '' }}>Kebakaran</option>
                    <option value="Kebakaran Hutan" {{ old('jenis_kejadian') == 'Kebakaran Hutan' ? 'selected' : '' }}>Kebakaran Hutan</option>
                    <option value="Hujan Deras" {{ old('jenis_kejadian') == 'Hujan Deras' ? 'selected' : '' }}>Hujan Deras</option>
                    <option value="Hujan Lebat" {{ old('jenis_kejadian') == 'Hujan Lebat' ? 'selected' : '' }}>Hujan Lebat</option>
                    <option value="Kabut Tebal" {{ old('jenis_kejadian') == 'Kabut Tebal' ? 'selected' : '' }}>Kabut Tebal</option>
                    <option value="Animal Hazard" {{ old('jenis_kejadian') == 'Animal Hazard' ? 'selected' : '' }}>Animal Hazard</option>
                    <option value="Wildlife Hazard" {{ old('jenis_kejadian') == 'Wildlife Hazard' ? 'selected' : '' }}>Wildlife Hazard</option>
                    <option value="Bird Strike" {{ old('jenis_kejadian') == 'Bird Strike' ? 'selected' : '' }}>Bird Strike</option>
                    <option value="Medis Gawat Darurat" {{ old('jenis_kejadian') == 'Medis Gawat Darurat' ? 'selected' : '' }}>Medis Gawat Darurat</option>
                    {{-- Options added from previous request --}}
                    <option value="FOD" {{ old('jenis_kejadian') == 'FOD' ? 'selected' : '' }}>FOD</option>
                    <option value="Runway Incursion" {{ old('jenis_kejadian') == 'Runway Incursion' ? 'selected' : '' }}>Runway Incursion</option>
                    <option value="Runway Excursion" {{ old('jenis_kejadian') == 'Runway Excursion' ? 'selected' : '' }}>Runway Excursion</option>
                    <option value="Ground Collision" {{ old('jenis_kejadian') == 'Ground Collision' ? 'selected' : '' }}>Ground Collision</option>
                    <option value="Lain Lain" {{ old('jenis_kejadian') == 'Lain Lain' ? 'selected' : '' }}>Lain Lain</option>
                </select>
                @error('jenis_kejadian')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="grid-row: span 2;">
                <label>Kronologi Kejadian <span class="req">*</span></label>
                <textarea name="kronologi" class="form-control" style="min-height:130px"
                    placeholder="Masukan uraian singkat tentang kronologi kejadian, penyebab, dan tindakan yang dilakukan"
                    required>{{ old('kronologi') }}</textarea>
                @error('kronologi')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Lokasi Kejadian <span class="req">*</span></label>
                <select name="lokasi" class="form-control" required>
                    <option value="">-- Pilih Lokasi --</option>
                    <option value="Runway" {{ old('lokasi') == 'Runway' ? 'selected' : '' }}>Runway</option>
                    <option value="Taxiway" {{ old('lokasi') == 'Taxiway' ? 'selected' : '' }}>Taxiway</option>
                    <option value="Apron" {{ old('lokasi') == 'Apron' ? 'selected' : '' }}>Apron</option>
                    <option value="Luar Bandara" {{ old('lokasi') == 'Luar Bandara' ? 'selected' : '' }}>Luar Bandara</option>
                    <option value="Terminal" {{ old('lokasi') == 'Terminal' ? 'selected' : '' }}>Terminal</option>
                    <option value="Hanggar" {{ old('lokasi') == 'Hanggar' ? 'selected' : '' }}>Hanggar</option>
                </select>
                @error('lokasi')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal & Waktu Kejadian <span class="req">*</span></label>
                <input type="datetime-local" name="tanggal_waktu" class="form-control"
                    value="{{ old('tanggal_waktu', now()->format('Y-m-d\TH:i')) }}" required>
                @error('tanggal_waktu')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Foto Dokumentasi</label>
                <div class="file-input-wrapper">
                    <input type="file" name="foto" accept=".jpg,.jpeg,.png" id="fotoInput">
                    <div class="file-input-display" id="fotoDisplay">
                        <span class="file-btn">Pilih File</span>
                        <span id="fotoName">Tidak ada yang dipilih</span>
                    </div>
                </div>
                <span class="form-hint">Unggah foto dokumentasi kejadian (maks 5MB, format: JPG, PNG)</span>
                @error('foto')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Nama Personel <span class="req">*</span></label>
                <input type="text" name="nama_personel" class="form-control"
                    placeholder="Masukan nama lengkap"
                    value="{{ old('nama_personel') }}" required>
                @error('nama_personel')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Regu <span class="req">*</span></label>
                <select name="regu" class="form-control" required>
                    <option value="">-- Pilih Regu --</option>
                    <option value="Alpha" {{ old('regu') == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                    <option value="Bravo" {{ old('regu') == 'Bravo' ? 'selected' : '' }}>Bravo</option>
                    <option value="Charlie" {{ old('regu') == 'Charlie' ? 'selected' : '' }}>Charlie</option>
                </select>
                @error('regu')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Shift <span class="req">*</span></label>
                <select name="shift" class="form-control" required>
                    <option value="">-- Pilih Shift --</option>
                    <option value="Pagi" {{ old('shift') == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                    <option value="Siang" {{ old('shift') == 'Siang' ? 'selected' : '' }}>Siang</option>
                    <option value="Malam" {{ old('shift') == 'Malam' ? 'selected' : '' }}>Malam</option>
                </select>
                @error('shift')
                    <span class="form-hint" style="color:#e53935">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Laporan</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // FOTO INPUT
    const fotoInput = document.getElementById('fotoInput');
    const fotoName = document.getElementById('fotoName');

    if (fotoInput && fotoName) {
        fotoInput.addEventListener('change', function () {
            fotoName.textContent = this.files.length > 0
                ? this.files[0].name
                : 'Tidak ada yang dipilih';
        });
    }

    // JENIS KEJADIAN LAIN-LAIN
    const jenisKejadianSelect = document.querySelector('select[name="jenis_kejadian"]');
    const customJenisKejadianGroup = document.getElementById('customJenisKejadianGroup');

    if (jenisKejadianSelect && customJenisKejadianGroup) {
        const customJenisKejadianInput = customJenisKejadianGroup.querySelector('input[name="custom_jenis_kejadian"]');

        function toggleCustomJenisKejadian() {
            if (jenisKejadianSelect.value === 'Lain Lain') {
                customJenisKejadianGroup.style.display = 'block';
                customJenisKejadianInput?.setAttribute('required', 'required');
            } else {
                customJenisKejadianGroup.style.display = 'none';
                customJenisKejadianInput?.removeAttribute('required');
                if (customJenisKejadianInput) customJenisKejadianInput.value = '';
            }
        }

        toggleCustomJenisKejadian();
        jenisKejadianSelect.addEventListener('change', toggleCustomJenisKejadian);
    }

});
</script>
@endpush
