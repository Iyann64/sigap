<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@sigap.test'], [
            'name' => 'Admin SIGAP',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nama_personel' => 'Admin SIGAP',
            'regu' => null,
            'shift' => null,
            'is_active' => true,
        ]);

        User::updateOrCreate(['email' => 'anggota@sigap.test'], [
            'name' => 'Anggota SIGAP',
            'password' => Hash::make('password'),
            'role' => 'anggota',
            'nama_personel' => 'Petugas SIGAP',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
            'is_active' => true,
        ]);

        $this->call([
            KejadianSeeder::class,
        ]);
    }
}
