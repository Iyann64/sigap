<?php

namespace Tests\Feature;

use App\Models\Kejadian;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KejadianAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_anggota_can_see_all_incident_reports(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);
        $otherUser = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $ownKejadian = Kejadian::create([
            'user_id' => $anggota->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Laporan milik anggota login',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Login',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $otherKejadian = Kejadian::create([
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
        $response->assertSee('Hujan Deras');
        $response->assertSee('Apron');
        $response->assertSee(route('data-kejadian.edit', $ownKejadian), false);
        $response->assertDontSee(route('data-kejadian.edit', $otherKejadian), false);
    }

    public function test_anggota_can_view_other_users_incident_detail(): void
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

        $response->assertOk();
        $response->assertSee('Laporan milik anggota lain');
    }

    public function test_anggota_cannot_edit_other_users_incident_report(): void
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

        $response = $this->actingAs($anggota)->get(route('data-kejadian.edit', $kejadian));

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

    public function test_data_kejadian_can_be_filtered_by_year(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        Kejadian::create([
            'user_id' => $anggota->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Laporan tahun 2025',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2025-01-10 08:30:00',
            'nama_personel' => 'Petugas Login',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        Kejadian::create([
            'user_id' => $anggota->id,
            'jenis_kejadian' => 'Hujan Deras',
            'kronologi' => 'Laporan tahun 2026',
            'lokasi' => 'Apron',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Login',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response = $this->actingAs($anggota)->get(route('data-kejadian', ['tahun' => 2025]));

        $response->assertOk();
        $response->assertSee('Kebakaran');
        $response->assertSee('Runway');
        $response->assertDontSee('Hujan Deras');
        $response->assertDontSee('Apron');
    }
}
