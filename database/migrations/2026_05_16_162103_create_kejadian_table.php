<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kejadian', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kejadian', 100);
            $table->text('kronologi');
            $table->string('lokasi', 100);
            $table->dateTime('tanggal_waktu');
            $table->string('foto')->nullable();
            $table->string('nama_personel', 150);
            $table->string('regu', 50);
            $table->string('shift', 50);
            $table->timestamps();

            // Index untuk query yang sering dipakai
            $table->index('tanggal_waktu');
            $table->index('jenis_kejadian');
            $table->index('regu');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kejadian');
    }
};