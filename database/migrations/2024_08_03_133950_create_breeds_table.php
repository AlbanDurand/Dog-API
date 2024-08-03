<?php

use App\Models\Breed;
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
        Schema::create('breeds', function (Blueprint $table) {
            $table->string('name')->nullable(false)->primary();
        });

        Schema::create('breedSummaryListSynchronizations', function (Blueprint $table) {
            $table->id();
            $table->timestamp('synchronized_at')->nullable(false);
        });

        Schema::create('breedSynchronizations', function (Blueprint $table) {
           $table->id();
           $table->string('breed_name')->nullable(false);
           $table->timestamp('synchronized_at')->nullable(false);

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
        Schema::dropIfExists('breedSummaryListSynchronizations');
        Schema::dropIfExists('breedSynchronizations');
        Schema::dropIfExists('breeds');
    }
};
