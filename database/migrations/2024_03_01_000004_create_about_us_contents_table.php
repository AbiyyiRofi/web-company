<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_us_contents', function (Blueprint $table) {
            $table->id();
            $table->string('header_image')->nullable();
            $table->string('header_caption')->nullable();
            $table->text('sekilas_text')->nullable();
            $table->text('sejarah_text')->nullable();
            $table->string('sejarah_bg_image')->nullable();
            $table->text('visi_text')->nullable();
            $table->text('misi_text')->nullable();
            $table->text('struktur_text')->nullable();
            $table->string('struktur_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us_contents');
    }
};
