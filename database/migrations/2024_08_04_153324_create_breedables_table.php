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
        Schema::create('breedables', function (Blueprint $table) {
            $table->id();
            $table->string('breed_name');
            $table->string('breedable_id');
            $table->string('breedable_type');

            $table
                ->foreign('breed_name')
                ->references('name')
                ->on('breeds')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breedables');
    }
};
