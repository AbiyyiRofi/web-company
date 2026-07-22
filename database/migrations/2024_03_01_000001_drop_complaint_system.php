<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sistem pengaduan online custom kita SUDAH TIDAK DIPAKAI — PDAM sudah
     * punya aplikasi sendiri (Banyu Digital). Tabel-tabel ini aman dihapus.
     */
    public function up(): void
    {
        Schema::dropIfExists('complaint_resolution_images');
        Schema::dropIfExists('complaint_resolutions');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('desas');
        Schema::dropIfExists('kecamatans');
    }

    public function down(): void
    {
        // Sengaja tidak dikembalikan.
    }
};
