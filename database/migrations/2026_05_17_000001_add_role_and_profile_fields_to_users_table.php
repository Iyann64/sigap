<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('anggota')->after('password');
            $table->string('nama_personel', 150)->nullable()->after('role');
            $table->string('regu', 50)->nullable()->after('nama_personel');
            $table->string('shift', 50)->nullable()->after('regu');
            $table->boolean('is_active')->default(true)->after('shift');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nama_personel', 'regu', 'shift', 'is_active']);
        });
    }
};
