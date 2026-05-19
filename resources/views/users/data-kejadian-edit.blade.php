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
                <select name="jenis_kejadian" class="form-control" required>
                    @php $options = ['Kebakaran', 'Kebakaran Hutan', 'Hujan Deras', 'FOD', 'Runway Incursion', 'Runway Excursion', 'Ground Collision', 'Lain Lain']; @endphp
                    <option value="">-- Pilih Jenis Kejadian --</option>
                    @foreach($options as $opt)
                        <option value="{{ $opt }}" {{ old('jenis_kejadian', $kejadian->jenis_kejadian) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
            
            <div id="customJenisKejadianGroup" class="form-group" style="display:none;">
                <label>Sebutkan Jenis Kejadian <span class="req">*</span></label>
                <input type="text" name="custom_jenis_kejadian" class="form-control" value="{{ old('custom_jenis_kejadian') }}">
            </div>

            <div class="form-group" style="grid-row: span 2;">
                <label>Kronologi Kejadian <span class="req">*</span></label>
                <textarea name="kronologi" class="form-control" style="min-height:130px" required>{{ old('kronologi', $kejadian->kronologi) }}</textarea>
            </div>

            <div class="form-group">
                <label>Lokasi Kejadian <span class="req">*</span></label>
                <select name="lokasi" class="form-control" required>
                    @foreach(['Runway', 'Taxiway', 'Apron', 'Terminal'] as $loc)
                        <option value="{{ $loc }}" {{ old('lokasi', $kejadian->lokasi) == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                    @endforeach
                </select>
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
    const select = document.querySelector('select[name="jenis_kejadian"]');
    const customGroup = document.getElementById('customJenisKejadianGroup');
    function checkCustom() {
        customGroup.style.display = select.value === 'Lain Lain' ? 'block' : 'none';
    }
    select.addEventListener('change', checkCustom);
    window.onload = checkCustom;
</script>
@endpush