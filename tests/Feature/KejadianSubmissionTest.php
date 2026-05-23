<?php

namespace Tests\Feature;

use App\Models\Kejadian;
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

    public function test_user_can_submit_custom_lain_lain_incident_type(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $response = $this->actingAs($user)->post(route('input.store'), [
            'jenis_kejadian' => 'Lain Lain',
            'custom_jenis_kejadian' => 'Tumpahan Bahan Bakar',
            'kronologi' => 'Terdapat tumpahan bahan bakar di apron dan sudah ditangani.',
            'lokasi' => 'Apron',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response->assertRedirect(route('data-kejadian'));

        $this->assertDatabaseHas('kejadian', [
            'user_id' => $user->id,
            'jenis_kejadian' => 'Tumpahan Bahan Bakar',
        ]);
        $this->assertDatabaseMissing('kejadian', [
            'user_id' => $user->id,
            'jenis_kejadian' => 'Lain Lain',
        ]);
    }

    public function test_user_can_submit_custom_lain_lain_location(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $response = $this->actingAs($user)->post(route('input.store'), [
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Terdapat asap di area khusus operasional.',
            'lokasi' => 'Lain Lain',
            'custom_lokasi' => 'Area GSE',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response->assertRedirect(route('data-kejadian'));

        $this->assertDatabaseHas('kejadian', [
            'user_id' => $user->id,
            'jenis_kejadian' => 'Kebakaran',
            'lokasi' => 'Area GSE',
        ]);
        $this->assertDatabaseMissing('kejadian', [
            'user_id' => $user->id,
            'lokasi' => 'Lain Lain',
        ]);
    }

    public function test_custom_lain_lain_type_is_required_when_selected(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $response = $this->actingAs($user)->from(route('input'))->post(route('input.store'), [
            'jenis_kejadian' => 'Lain Lain',
            'kronologi' => 'Terdapat kejadian lain di area runway.',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response->assertRedirect(route('input'));
        $response->assertSessionHasErrors(['custom_jenis_kejadian']);
        $this->assertDatabaseCount('kejadian', 0);
    }

    public function test_custom_lain_lain_location_is_required_when_selected(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);

        $response = $this->actingAs($user)->from(route('input'))->post(route('input.store'), [
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Terdapat kejadian di lokasi lain.',
            'lokasi' => 'Lain Lain',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response->assertRedirect(route('input'));
        $response->assertSessionHasErrors(['custom_lokasi']);
        $this->assertDatabaseCount('kejadian', 0);
    }

    public function test_user_can_update_incident_to_custom_lain_lain_type(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);
        $kejadian = Kejadian::create([
            'user_id' => $user->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Kronologi awal',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response = $this->actingAs($user)->put(route('data-kejadian.update', $kejadian), [
            'jenis_kejadian' => 'Lain Lain',
            'custom_jenis_kejadian' => 'Tumpahan Oli',
            'kronologi' => 'Terdapat tumpahan oli di taxiway.',
            'lokasi' => 'Taxiway',
            'tanggal_waktu' => '2026-01-10 09:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Bravo',
            'shift' => 'Siang',
        ]);

        $response->assertRedirect(route('data-kejadian'));

        $this->assertDatabaseHas('kejadian', [
            'id' => $kejadian->id,
            'jenis_kejadian' => 'Tumpahan Oli',
            'kronologi' => 'Terdapat tumpahan oli di taxiway.',
        ]);
    }

    public function test_user_can_update_incident_to_custom_lain_lain_location(): void
    {
        $user = User::factory()->create(['role' => 'anggota', 'is_active' => true]);
        $kejadian = Kejadian::create([
            'user_id' => $user->id,
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Kronologi awal',
            'lokasi' => 'Runway',
            'tanggal_waktu' => '2026-01-10 08:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Alpha',
            'shift' => 'Pagi',
        ]);

        $response = $this->actingAs($user)->put(route('data-kejadian.update', $kejadian), [
            'jenis_kejadian' => 'Kebakaran',
            'kronologi' => 'Terdapat kejadian di access road.',
            'lokasi' => 'Lain Lain',
            'custom_lokasi' => 'Access Road',
            'tanggal_waktu' => '2026-01-10 09:30:00',
            'nama_personel' => 'Petugas Test',
            'regu' => 'Bravo',
            'shift' => 'Siang',
        ]);

        $response->assertRedirect(route('data-kejadian'));

        $this->assertDatabaseHas('kejadian', [
            'id' => $kejadian->id,
            'jenis_kejadian' => 'Kebakaran',
            'lokasi' => 'Access Road',
        ]);
    }
}
