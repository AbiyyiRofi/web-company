<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Karir sekarang punya 2 gambar: header (blur di atas) + poster info (jelas di body)
        Schema::table('karir_contents', function (Blueprint $table) {
            $table->string('header_image')->nullable()->after('id');
            $table->string('header_caption')->nullable()->after('header_image');
        });

        // Highlight statistik di beranda (120K+ dst) - sekarang bisa di-CRUD admin, maks 4
        Schema::create('highlights', function (Blueprint $table) {
            $table->id();
            $table->string('value');   // "120K+"
            $table->string('label');   // "Pelanggan Aktif"
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Header poster generik buat sub-fitur (Galeri, Pengumuman, Publikasi, dst)
        // dibedain lewat kolom "key" biar gak perlu bikin tabel terpisah tiap sub-fitur
        Schema::create('page_headers', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // 'galeri' | 'pengumuman' | 'publikasi'
            $table->string('header_image')->nullable();
            $table->string('header_caption')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('karir_contents', function (Blueprint $table) {
            $table->dropColumn(['header_image', 'header_caption']);
        });
        Schema::dropIfExists('highlights');
        Schema::dropIfExists('page_headers');
    }
};
