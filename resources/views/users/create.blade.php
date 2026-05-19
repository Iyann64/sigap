@extends('layouts.sigap')
@section('title', 'Tambah Anggota')
@section('content')
<div class="page-title"><span></span> Tambah Anggota Baru</div>
<div class="card">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Username (Login) <span class="req">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') <span class="form-hint" style="color:#e53935">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Email <span class="req">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <span class="form-hint" style="color:#e53935">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Password <span class="req">*</span></label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <span class="form-hint" style="color:#e53935">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Hak Akses / Role <span class="req">*</span></label>
                <select name="role" class="form-control" required>
                    <option value="anggota">Anggota (Input & Edit Laporan)</option>
                    <option value="admin">Admin (Full Akses)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Lengkap Personel <span class="req">*</span></label>
                <input type="text" name="nama_personel" class="form-control" value="{{ old('nama_personel') }}" required>
            </div>
            <div class="form-group">
                <label>Regu</label>
                <select name="regu" class="form-control">
                    <option value="">-- Pilih Regu --</option>
                    <option value="Alpha">Alpha</option>
                    <option value="Bravo">Bravo</option>
                    <option value="Charlie">Charlie</option>
                    <option value="Delta">Delta</option>
                </select>
            </div>
            <div class="form-group">
                <label>Shift</label>
                <select name="shift" class="form-control">
                    <option value="">-- Pilih Shift --</option>
                    <option value="Pagi">Pagi</option>
                    <option value="Siang">Siang</option>
                    <option value="Malam">Malam</option>
                </select>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:10px; padding-top:25px">
                <input type="checkbox" name="is_active" value="1" checked id="is_active">
                <label for="is_active" style="margin:0">Akun Aktif</label>
            </div>
        </div>
        <div class="form-actions" style="margin-top:20px">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Anggota</button>
        </div>
    </form>
</div>
@endsection
