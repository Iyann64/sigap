<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_shows_recent_user_activity(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        ActivityLog::create([
            'user_id' => $anggota->id,
            'action' => 'kejadian.created',
            'description' => 'Membuat laporan kejadian: Kebakaran',
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Aktivitas User Terbaru');
        $response->assertSee('Membuat laporan kejadian: Kebakaran');
        $response->assertSee($anggota->name);
    }

    public function test_anggota_dashboard_does_not_show_user_activity_panel(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        ActivityLog::create([
            'user_id' => $anggota->id,
            'action' => 'kejadian.created',
            'description' => 'Membuat laporan kejadian: Kebakaran',
        ]);

        $response = $this->actingAs($anggota)->get(route('dashboard'));

        $response->assertOk();
        $response->assertDontSee('Aktivitas User Terbaru');
    }

    public function test_admin_dashboard_paginates_user_activity(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        for ($i = 1; $i <= 7; $i++) {
            ActivityLog::create([
                'user_id' => $anggota->id,
                'action' => 'kejadian.created',
                'description' => "Aktivitas dashboard {$i}",
                'created_at' => now()->subMinutes(10 - $i),
                'updated_at' => now()->subMinutes(10 - $i),
            ]);
        }

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Menampilkan');
        $response->assertSee('dari');
        $response->assertSee('7');
        $response->assertSee('activity_page=2', false);
        $response->assertSee('#aktivitas-user', false);
        $response->assertSee('Aktivitas dashboard 7');
        $response->assertDontSee('Aktivitas dashboard 1');
    }

    public function test_creating_incident_report_writes_activity_log(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $this->actingAs($anggota)->post(route('input.store'), [
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Terdeteksi asap di area runway.',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $anggota->id,
            'action' => 'kejadian.created',
            'description' => 'Membuat laporan kejadian: Kebakaran',
        ]);
    }
}
