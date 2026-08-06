<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_us_contents', function (Blueprint $table) {
            $table->text('harapan_text')->nullable()->after('sekilas_text');
            $table->string('harapan_photo')->nullable()->after('harapan_text');
        });
    }

    public function down(): void
    {
        Schema::table('about_us_contents', function (Blueprint $table) {
            $table->dropColumn(['harapan_text', 'harapan_photo']);
        });
    }
};