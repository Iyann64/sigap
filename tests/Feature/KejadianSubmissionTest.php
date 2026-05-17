<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KejadianSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_incident_report(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $response = $this->actingAs($user)->post(route('input.store'), [
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Terdeteksi asap di area runway dan petugas segera melakukan penanganan.',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response->assertRedirect(route('data-kejadian'));
        $response->assertSessionHas('success', 'Laporan kejadian berhasil disimpan!');

        $this->assertDatabaseHas('kejadian', [
            'user_id' => $user->id,
            'jenis_kejadian' => 'Kebakaran',
            'lokasi' => 'Runway',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);
    }

    public function test_submit_incident_report_requires_mandatory_fields(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $response = $this->actingAs($user)->from(route('input'))->post(route('input.store'), []);

        $response->assertRedirect(route('input'));
        $response->assertSessionHasErrors([
            'jenis_kejadian',
            'kronologi',
            'lokasi',
            'tanggal_waktu',
            'nama_personel',
            'regu',
            'shift',
        ]);
        $this->assertDatabaseCount('kejadian', 0);
    }
}
