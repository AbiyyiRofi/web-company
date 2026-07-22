<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1) Tabel baru khusus poster Karir (bisa banyak, bisa dijadwalkan, bisa dihapus+riwayat)
        Schema::create('karir_posters', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2) Pindahkan poster lama (kalau ada) dari karir_contents ke tabel baru, biar gak hilang
        $old = DB::table('karir_contents')->whereNotNull('poster_image')->first();
        if ($old && $old->poster_image) {
            DB::table('karir_posters')->insert([
                'image' => $old->poster_image,
                'start_date' => null,
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3) Kolom poster_image di karir_contents sudah gak dipakai lagi
        Schema::table('karir_contents', function (Blueprint $table) {
            $table->dropColumn('poster_image');
        });

        // 4) Pengumuman: tambah jadwal tayang + soft delete (riwayat)
        Schema::table('announcements', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('description');
            $table->date('end_date')->nullable()->after('start_date');
            $table->softDeletes();
        });

        // 5) Pengadaan: soft delete saja (riwayat, tanpa jadwal tayang)
        Schema::table('procurements', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('procurements', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['start_date', 'end_date']);
        });

        Schema::table('karir_contents', function (Blueprint $table) {
            $table->string('poster_image')->nullable();
        });

        Schema::dropIfExists('karir_posters');
    }
};