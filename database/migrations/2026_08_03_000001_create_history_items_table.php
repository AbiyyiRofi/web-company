<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_items', function (Blueprint $table) {
            $table->id();
            $table->string('year'); // e.g. "1932", "1945", "1957 - 1967"
            $table->string('title')->nullable(); // e.g. "Perjalanan 1932" or short title
            $table->text('content'); // Narasi sejarah
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_items');
    }
};
