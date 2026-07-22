<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PENTING: drop foreign key & kolom DULU selagi tabel masih bernama
        // "reports" (nama constraint mengikuti nama tabel saat dibuat),
        // baru rename belakangan.
        Schema::table('reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('branch_id');
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['status', 'is_pinned', 'is_published', 'category', 'excerpt']);
        });

        Schema::rename('reports', 'news');

        Schema::rename('report_images', 'news_images');
        Schema::table('news_images', function (Blueprint $table) {
            $table->renameColumn('report_id', 'news_id');
        });
    }

    public function down(): void
    {
        Schema::rename('news', 'reports');
        Schema::rename('news_images', 'report_images');
    }
};