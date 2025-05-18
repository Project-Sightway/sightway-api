<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyandang_pemantau', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyandang_id')->constrained('penyandang')->onDelete('cascade');
            $table->foreignId('pemantau_id')->constrained('pemantau')->onDelete('cascade');
            $table->string('relation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyandang_pemantau');
    }
};
