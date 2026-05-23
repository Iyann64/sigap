<?php

namespace Tests\Feature;

use App\Models\Kejadian;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GrafikTest extends TestCase
{
    use RefreshDatabase;

    public function test_grafik_uses_incident_data_from_database(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        Kejadian::create([
            'user_id' => $user->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Kejadian uji',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        Kejadian::create([
            'user_id' => $user->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Kejadian uji kedua',
            'lokasi' => 'Apron',
            'tanggal_waktu' => '2026-01-11 09:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response = $this->actingAs($user)->get('/grafik?tahun=2026');

        $response->assertOk();
        $response->assertSee('"label":"Kebakaran"', false);
        $response->assertSee('"data":[2,0,0,0,0,0,0,0,0,0,0,0]', false);
    }

    public function test_grafik_shows_custom_lain_lain_type_as_its_own_label(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        Kejadian::create([
            'user_id' => $user->id,
            'jenis_kejadian' => 'Tumpahan Bahan Bakar',
            'kronologi' => 'Terdapat tumpahan bahan bakar di apron.',
            'lokasi' => 'Apron',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response = $this->actingAs($user)->get('/grafik?tahun=2026');

        $response->assertOk();
        $response->assertSee('"label":"Tumpahan Bahan Bakar"', false);
        $response->assertDontSee('"label":"Lain Lain"', false);
    }
}
