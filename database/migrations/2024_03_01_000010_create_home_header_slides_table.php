<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_header_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('file_path');
            $table->unsignedInteger('duration_seconds')->default(6); // dipakai buat progress bar
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_header_slides');
    }
};
