<?php

namespace Tests\Feature;

use App\Models\Kejadian;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KejadianDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_incident_removes_database_record(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $kejadian = Kejadian::create([
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Kejadian uji tanpa foto',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response = $this->actingAs($admin)->delete(route('data-kejadian.destroy', $kejadian));

        $response->assertRedirect(route('data-kejadian'));
        $response->assertSessionHas('success', 'Data berhasil dihapus.');
        $this->assertDatabaseMissing('kejadian', ['id' => $kejadian->id]);
    }

    public function test_deleting_incident_removes_photo_from_storage(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        Storage::fake('public');

        $photoPath = UploadedFile::fake()
            ->image('kejadian.jpg')
            ->store('kejadian', 'public');

        $kejadian = Kejadian::create([
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Kejadian uji dengan foto',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'foto' => $photoPath,
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        Storage::disk('public')->assertExists($photoPath);

        $response = $this->actingAs($admin)->delete(route('data-kejadian.destroy', $kejadian));

        $response->assertRedirect(route('data-kejadian'));
        Storage::disk('public')->assertMissing($photoPath);
        $this->assertDatabaseMissing('kejadian', ['id' => $kejadian->id]);
    }

    public function test_anggota_cannot_delete_incident_report(): void
    {
        $anggota = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $kejadian = Kejadian::create([
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Kejadian uji',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response = $this->actingAs($anggota)->delete(route('data-kejadian.destroy', $kejadian));

        $response->assertForbidden();
        $this->assertDatabaseHas('kejadian', ['id' => $kejadian->id]);
    }
}
