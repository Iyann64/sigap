<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil hanya anggota yang memiliki regu, diurutkan berdasarkan regu dan nama,
        // lalu dikelompokkan berdasarkan regu.
        $usersGrouped = User::where('role', 'anggota')
            ->whereNotNull('regu')
            ->orderBy('regu')
            ->orderBy('name')
            ->get()
            ->groupBy('regu');
        return view('users.index', compact('usersGrouped'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => ['required', Rule::in(['admin', 'anggota'])],
            'nama_personel' => 'required|string|max:150',
            'regu' => 'nullable|string',
            'shift' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        $user = User::create($validated);
        ActivityLog::record('user.created', 'Menambahkan user: ' . $user->name, $user, $request);

        return redirect()->route('users.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8',
            'role' => ['required', Rule::in(['admin', 'anggota'])],
            'nama_personel' => 'required|string|max:150',
            'regu' => 'nullable|string',
            'shift' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);
        ActivityLog::record('user.updated', 'Mengubah data user: ' . $user->name, $user, $request);

        return redirect()->route('users.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        ActivityLog::record('user.deleted', 'Menghapus user: ' . $user->name, $user);

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
