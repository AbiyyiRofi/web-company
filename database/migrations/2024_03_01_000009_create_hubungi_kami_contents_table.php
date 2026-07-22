<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hubungi_kami_contents', function (Blueprint $table) {
            $table->id();
            $table->string('header_image')->nullable();
            $table->string('header_caption')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hubungi_kami_contents');
    }
};
