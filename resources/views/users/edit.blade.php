@extends('layouts.sigap')
@section('title', 'Edit Anggota')
@section('content')
<div class="page-title"><span></span> Edit Data Anggota</div>
<div class="card">
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label>Password (Kosongkan jika tidak ganti)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Hak Akses</label>
                <select name="role" class="form-control" required>
                    <option value="anggota" {{ $user->role == 'anggota' ? 'selected' : '' }}>Anggota</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Lengkap Personel</label>
                <input type="text" name="nama_personel" class="form-control" value="{{ old('nama_personel', $user->nama_personel) }}" required>
            </div>
            <div class="form-group">
                <label>Regu</label>
                <select name="regu" class="form-control">
                    @foreach(['Alpha', 'Bravo', 'Charlie', 'Delta'] as $r)
                        <option value="{{ $r }}" {{ old('regu', $user->regu) == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Shift</label>
                <select name="shift" class="form-control">
                    @foreach(['Pagi', 'Siang', 'Malam'] as $s)
                        <option value="{{ $s }}" {{ old('shift', $user->shift) == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:10px; padding-top:25px">
                <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} id="is_active">
                <label for="is_active" style="margin:0">Akun Aktif</label>
            </div>
        </div>
        <div class="form-actions" style="margin-top:20px">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
    </form>
</div>
@endsection
