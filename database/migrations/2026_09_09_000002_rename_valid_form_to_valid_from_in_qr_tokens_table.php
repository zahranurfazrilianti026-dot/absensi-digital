<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migration awal menulis nama kolom salah ketik: "valid_form"
        // seharusnya "valid_from". Kita perbaiki di sini tanpa mengubah
        // migration lama (karena migration lama sudah pernah dijalankan).
        //
        // Menggunakan raw SQL "CHANGE COLUMN" (bukan Schema::renameColumn)
        // karena sintaks "RENAME COLUMN ... TO ..." baru didukung mulai
        // MariaDB 10.5.2 / MySQL 8.0. CHANGE COLUMN kompatibel dengan versi lama.
        DB::statement('ALTER TABLE qr_tokens CHANGE valid_form valid_from DATETIME NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE qr_tokens CHANGE valid_from valid_form DATETIME NOT NULL');
    }
};
