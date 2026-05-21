<?php

namespace Tests\Feature;

use App\Models\Kejadian;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_anggota_only_sees_own_reports_on_laporan_page(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);
        $otherUser = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $this->createKejadian($anggota, 'Kebakaran', 'Laporan milik user login');
        $this->createKejadian($otherUser, 'Hujan Deras', 'Laporan milik user lain');

        $response = $this->actingAs($anggota)->get(route('laporan.index'));

        $response->assertOk();
        $response->assertSee('Laporan milik user login');
        $response->assertDontSee('Laporan milik user lain');
    }

    public function test_admin_can_see_all_reports_on_laporan_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);
        $otherUser = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $this->createKejadian($anggota, 'Kebakaran', 'Laporan anggota pertama');
        $this->createKejadian($otherUser, 'Hujan Deras', 'Laporan anggota kedua');

        $response = $this->actingAs($admin)->get(route('laporan.index'));

        $response->assertOk();
        $response->assertSee('Laporan anggota pertama');
        $response->assertSee('Laporan anggota kedua');
    }

    public function test_laporan_filter_uses_jenis_kejadian_parameter(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $this->createKejadian($anggota, 'Kebakaran', 'Laporan kebakaran', 'Runway');
        $this->createKejadian($anggota, 'Hujan Deras', 'Laporan hujan deras', 'Apron');

        $response = $this->actingAs($anggota)->get(route('laporan.index', [
            'jenis_kejadian' => 'Kebakaran',
        ]));

        $response->assertOk();
        $response->assertSee('Laporan kebakaran');
        $response->assertDontSee('Laporan hujan deras');
    }

    public function test_laporan_filter_uses_lokasi_parameter(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $this->createKejadian($anggota, 'Kebakaran', 'Laporan runway', 'Runway');
        $this->createKejadian($anggota, 'Kebakaran', 'Laporan apron', 'Apron');

        $response = $this->actingAs($anggota)->get(route('laporan.index', [
            'lokasi' => 'Runway',
        ]));

        $response->assertOk();
        $response->assertSee('Laporan runway');
        $response->assertDontSee('Laporan apron');
    }

    public function test_laporan_filter_shows_custom_jenis_kejadian_from_visible_reports(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);
        $otherUser = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $this->createKejadian($anggota, 'Tumpahan Bahan Bakar', 'Laporan custom user login');
        $this->createKejadian($otherUser, 'Gangguan Milik User Lain', 'Laporan user lain');

        $response = $this->actingAs($anggota)->get(route('laporan.index'));

        $response->assertOk();
        $response->assertSee('Tumpahan Bahan Bakar');
        $response->assertDontSee('Gangguan Milik User Lain');
    }

    private function createKejadian(User $user, string $jenisKejadian, string $kronologi, string $lokasi = 'Runway'): Kejadian
    {
        return Kejadian::create([
            'user_id' => $user->id,
            'jenis_kejadian' => $jenisKejadian,
            'kronologi' => $kronologi,
            'lokasi' => $lokasi,
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => $user->name,
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);
    }
}
