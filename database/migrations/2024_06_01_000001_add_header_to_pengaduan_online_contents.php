<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduan_online_contents', function (Blueprint $table) {
            $table->string('header_image')->nullable()->after('id');
            $table->string('header_caption')->nullable()->after('header_image');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan_online_contents', function (Blueprint $table) {
            $table->dropColumn(['header_image', 'header_caption']);
        });
    }
};
