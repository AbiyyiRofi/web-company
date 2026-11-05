<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leadership_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('period'); // e.g., "1978 - 1985"
            $table->string('position')->nullable(); // e.g., "Direktur Utama"
            $table->string('photo')->nullable();
            $table->integer('sort_order')->default(0);
            $table->integer('duration')->default(6000); // milliseconds (6 seconds default)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leadership_histories');
    }
};
