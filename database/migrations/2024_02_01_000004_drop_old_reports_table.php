<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel `reports` versi lama (upload 1 file PDF/Word buat didownload) sudah
     * tidak dipakai — digantikan dengan konsep baru "Laporan Kegiatan" yang
     * menyatu dengan `news` (lihat migration berikutnya yang rename news -> reports).
     */
    public function up(): void
    {
        Schema::dropIfExists('reports');
    }

    public function down(): void
    {
        // Sengaja tidak dikembalikan — struktur lama sudah digantikan total.
    }
};
