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
        Schema::create('parks', function (Blueprint $table) {
           $table->uuid('id')->primary();
           $table->string('name', 32);
        });

        Schema::create('parkables', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('park_id')->constrained('parks')->cascadeOnDelete();
            $table->string('parkable_id');
            $table->string('parkable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkables');
        Schema::dropIfExists('parks');
    }
};
