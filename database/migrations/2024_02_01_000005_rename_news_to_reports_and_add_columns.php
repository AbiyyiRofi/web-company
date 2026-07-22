<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `news` (Berita) dan `reports` lama (Laporan Kegiatan) digabung jadi satu
     * entitas: tabel `reports`, dipakai sebagai "Laporan Kegiatan" di admin,
     * tampil sebagai "Info Terkini" di publik.
     */
    public function up(): void
    {
        Schema::rename('news', 'reports');

        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->after('user_id')
                ->constrained()->nullOnDelete(); // null = diupload super_admin (PDAM Pusat)
            $table->string('status')->default('pending')->after('is_published'); // pending|approved|rejected
            $table->boolean('is_pinned')->default(false)->after('status');
            $table->foreignId('approved_by')->nullable()->after('is_pinned')
                ->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });

        // Perluas enum kategori supaya menampung "laporan_kegiatan"
        DB::statement("ALTER TABLE reports MODIFY category ENUM('berita','pengumuman','gangguan_layanan','laporan_kegiatan') DEFAULT 'laporan_kegiatan'");

        // Migrasi data lama: yang sebelumnya is_published = true, anggap approved
        DB::table('reports')->where('is_published', true)->update([
            'status' => 'approved',
            'approved_at' => DB::raw('published_at'),
        ]);
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('branch_id');
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['status', 'is_pinned']);
        });

        Schema::rename('reports', 'news');
    }
};
