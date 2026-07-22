<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // procurement_contents sekarang CUMA nyimpen header (poster) halaman Pengadaan
        Schema::table('procurement_contents', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });

        // tabel baru: tiap "post" pengadaan (bisa banyak, masing-masing punya dokumen sendiri)
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // pindahin dokumen dari nempel ke procurement_content -> nempel ke procurement (post) tertentu
        Schema::table('procurement_documents', function (Blueprint $table) {
            $table->foreignId('procurement_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });
        Schema::table('procurement_documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('procurement_content_id');
        });
    }

    public function down(): void
    {
        Schema::table('procurement_contents', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('description')->nullable();
        });

        Schema::table('procurement_documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('procurement_id');
        });

        Schema::dropIfExists('procurements');
    }
};
