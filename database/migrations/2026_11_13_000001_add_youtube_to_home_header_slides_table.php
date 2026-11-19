<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('home_header_slides', function (Blueprint $table) {
            if (!Schema::hasColumn('home_header_slides', 'youtube_url')) {
                $table->string('youtube_url')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('home_header_slides', 'youtube_id')) {
                $table->string('youtube_id', 50)->nullable()->after('youtube_url');
            }
        });

        DB::statement("ALTER TABLE home_header_slides MODIFY COLUMN media_type VARCHAR(20) NOT NULL DEFAULT 'image'");
        DB::statement("ALTER TABLE home_header_slides MODIFY COLUMN file_path VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_header_slides', function (Blueprint $table) {
            if (Schema::hasColumn('home_header_slides', 'youtube_id')) {
                $table->dropColumn('youtube_id');
            }
            if (Schema::hasColumn('home_header_slides', 'youtube_url')) {
                $table->dropColumn('youtube_url');
            }
        });

        DB::statement("ALTER TABLE home_header_slides MODIFY COLUMN file_path VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE home_header_slides MODIFY COLUMN media_type ENUM('image', 'video') NOT NULL DEFAULT 'image'");
    }
};

