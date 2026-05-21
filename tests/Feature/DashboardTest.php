<?php

namespace Tests\Feature;

use App\Models\Kejadian;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_monthly_incident_counts_for_current_year(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);
        $year = now()->year;

        Kejadian::create([
            'user_id' => $user->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Kejadian Januari pertama',
            'lokasi' => 'Runway',
            'tanggal_waktu' => "{$year}-01-10 08:30:00",
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        Kejadian::create([
            'user_id' => $user->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Kejadian Januari kedua',
            'lokasi' => 'Apron',
            'tanggal_waktu' => "{$year}-01-11 08:30:00",
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        Kejadian::create([
            'user_id' => $user->id,
            'jenis_kejadian' => 'Hujan Deras',
            'kronologi' => 'Kejadian Maret',
            'lokasi' => 'Taxiway',
            'tanggal_waktu' => "{$year}-03-11 08:30:00",
            'nama_personel' => 'Petugas Test',
            'regu' => 'Bravo',
            'shift' => 'Siang',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('[2,0,1,0,0,0,0,0,0,0,0,0]', false);
    }
}
