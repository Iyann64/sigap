<?php

namespace Database\Seeders;

use App\Models\Kejadian;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KejadianSeeder extends Seeder
{
    public function run(): void
    {
        $anggota = \App\Models\User::where('email', 'anggota@sigap.test')->first();

        if (Kejadian::exists()) {
            $this->command->info('Data kejadian sudah ada, seeder dilewati.');

            return;
        }

        $jenisKejadian = [
            'Kebakaran Hutan',
            'Hujan Deras',
            'Hujan Lebat',
            'Kabut Tebal',
            'Animal Hazard',
            'Wildlife Hazard',
            'Bird Strike',
            'Medis Gawat Darurat',
            'FOD',
            'Runway Incursion',
            'Runway Excursion',
            'Ground Collision',
            'Lain Lain',
            'Kebakaran',
        ];

        $lokasi = ['Runway', 'Taxiway', 'Apron', 'Luar Bandara', 'Terminal', 'Hanggar'];

        $personel = [
            'Budi Santoso',
            'Agus Prayogo',
            'Siti Rahayu',
            'Dedi Kurniawan',
            'Rina Wulandari',
            'Hendra Pratama',
            'Yuni Astuti',
            'Fajar Nugroho',
            'Dewi Lestari',
        ];

        $regu = ['Alpha', 'Bravo', 'Charlie'];
        $shift = ['Pagi', 'Siang', 'Malam'];

        $kronologiTemplate = [
            'Terdeteksi asap di area %s, petugas segera melakukan pengecekan dan memadamkan api sebelum membesar.',
            'Curah hujan tinggi mengakibatkan genangan di %s, tim PKP-PK standby dan memasang rambu peringatan.',
            'Ditemukan hewan liar di area %s, tim melakukan penggiringan ke area aman sesuai prosedur.',
            'Kejadian terjadi di area %s, petugas segera merespons dan melakukan penanganan sesuai SOP.',
            'Teridentifikasi kondisi berbahaya di %s, koordinasi dengan supervisor dan unit terkait dilakukan segera.',
        ];

        for ($i = 0; $i < 50; $i++) {
            $lok = $lokasi[array_rand($lokasi)];
            $kron = sprintf(
                $kronologiTemplate[array_rand($kronologiTemplate)],
                $lok
            );

            Kejadian::create([
                'user_id' => $anggota?->id,
                'jenis_kejadian' => $jenisKejadian[array_rand($jenisKejadian)],
                'kronologi' => $kron,
                'lokasi' => $lok,
                'tanggal_waktu' => Carbon::now()
                    ->subDays(rand(0, 365))
                    ->setTime(rand(6, 22), rand(0, 59)),
                'foto' => null,
                'nama_personel' => $personel[array_rand($personel)],
                'regu' => $regu[array_rand($regu)],
                'shift' => $shift[array_rand($shift)],
            ]);
        }

        $this->command->info('50 data kejadian berhasil di-seed!');
    }
}
