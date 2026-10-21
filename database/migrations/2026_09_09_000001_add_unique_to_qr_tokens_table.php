<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qr_tokens', function (Blueprint $table) {
            // Mencegah satu lokasi mempunyai lebih dari satu token aktif
            // untuk tanggal yang sama.
            $table->unique(['qr_location_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::table('qr_tokens', function (Blueprint $table) {
            $table->dropUnique(['qr_location_id', 'date']);
        });
    }
};
