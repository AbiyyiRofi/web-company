<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        Schema::create('karir_contents', function (Blueprint $table) {
            $table->id();
            $table->string('poster_image')->nullable();
            $table->timestamps();
        });

        Schema::create('pengaduan_online_contents', function (Blueprint $table) {
            $table->id();
            $table->string('poster_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('karir_contents');
        Schema::dropIfExists('pengaduan_online_contents');
    }
};
