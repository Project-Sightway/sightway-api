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
        Schema::create('log_blindsticks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blindstick_id')->constrained('blind_sticks')->onDelete('cascade');
            $table->enum('status', ['normal', 'danger'])->default('normal');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_blindsticks');
    }
};
