<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('kecamatan_id')->constrained();
            $table->foreignId('desa_id')->constrained();
            $table->string('title');
            $table->text('message');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // baru -> diteruskan -> selesai
            $table->string('status')->default('baru');

            $table->foreignId('assigned_branch_id')->nullable()
                ->constrained('branches')->nullOnDelete();
            $table->foreignId('assigned_by')->nullable()
                ->constrained('users')->nullOnDelete(); // super_admin yang disposisi
            $table->timestamp('assigned_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
