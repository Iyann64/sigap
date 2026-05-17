<?php

namespace Tests\Feature;

use App\Models\Kejadian;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KejadianAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_anggota_only_sees_own_incident_reports(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);
        $otherUser = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        Kejadian::create([
            'user_id' => $anggota->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Laporan milik anggota login',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Login',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        Kejadian::create([
            'user_id' => $otherUser->id,
            'jenis_kejadian' => 'Hujan Deras',
            'kronologi' => 'Laporan milik anggota lain',
            'lokasi' => 'Apron',
            'tanggal_waktu' => '2026-01-11 08:30:00',
            'nama_personel' => 'Petugas Lain',
            'regu' => 'Bravo',
            'shift' => 'Malam',
        ]);

        $response = $this->actingAs($anggota)->get(route('data-kejadian'));

        $response->assertOk();
        $response->assertSee('Kebakaran');
        $response->assertSee('Runway');
        $response->assertDontSee('Hujan Deras');
        $response->assertDontSee('Apron');
    }

    public function test_anggota_cannot_view_other_users_incident_detail(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);
        $otherUser = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $kejadian = Kejadian::create([
            'user_id' => $otherUser->id,
            'jenis_kejadian' => 'Hujan Deras',
            'kronologi' => 'Laporan milik anggota lain',
            'lokasi' => 'Apron',
            'tanggal_waktu' => '2026-01-11 08:30:00',
            'nama_personel' => 'Petugas Lain',
            'regu' => 'Bravo',
            'shift' => 'Malam',
        ]);

        $response = $this->actingAs($anggota)->get(route('data-kejadian.show', $kejadian));

        $response->assertForbidden();
    }

    public function test_admin_can_see_all_incident_reports(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        Kejadian::create([
            'user_id' => $anggota->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Laporan milik anggota',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Login',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response = $this->actingAs($admin)->get(route('data-kejadian'));

        $response->assertOk();
        $response->assertSee('Kebakaran');
        $response->assertSee('Runway');
    }
}
