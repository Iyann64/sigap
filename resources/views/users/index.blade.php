@extends('layouts.sigap')

@section('title', 'Manajemen Anggota')

@section('content')
<div class="page-title">
    <span></span> Manajemen Anggota
</div>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <div class="table-meta">
            Total Anggota: <strong>{{ $usersGrouped->flatten()->count() }}</strong>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Anggota</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($usersGrouped as $regu => $members)
        <div class="regu-section" style="margin-bottom: 30px;">
            <h3 style="margin-bottom: 12px; color: var(--blue-main); font-size: 16px; border-bottom: 2px solid var(--bg); padding-bottom: 8px;">
                <i class="fas fa-users-cog"></i> Regu: {{ $regu }}
            </h3>
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Nama Personel</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="width:120px; text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $i => $user)
                    <tr>
                        <td>{{ $i + 1 }}.</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nama_personel }}</td>
                        <td><span class="badge {{ $user->role == 'admin' ? 'badge-admin' : 'badge-anggota' }}">{{ ucfirst($user->role) }}</span></td>
                        <td>{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td style="text-align:center">
                            <a href="{{ route('users.edit', $user) }}" style="color:var(--orange); font-size:12px; font-weight:700; text-decoration:none; margin-right:8px;">Edit</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus anggota ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none; border:none; color:#e53935; font-size:12px; font-weight:700; cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p style="text-align: center; padding: 20px; color: var(--text-light);">Belum ada data anggota.</p>
    @endforelse
</div>

<style>
.badge-admin { background: #e0f2fe; color: #0369a1; }
.badge-anggota { background: #f0fdf4; color: #166534; }
</style>
@endsection
