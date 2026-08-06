<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('type')->default('cabang')->after('name');
            $table->text('kapasitas_terpasang_text')->nullable()->after('operational_hours');
            $table->string('kapasitas_produksi')->nullable()->after('kapasitas_terpasang_text');
            $table->string('idle_capacity')->nullable()->after('kapasitas_produksi');
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn(['type', 'kapasitas_terpasang_text', 'kapasitas_produksi', 'idle_capacity']);
        });
    }
};