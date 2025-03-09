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
        Schema::create('nilai_kriteria_wilayah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_kelurahan_id')->constrained('wilayah_kelurahan');
            $table->foreignId('kriteria_id')->constrained('kriteria');
            $table->float('nilai')->nullable();
            $table->enum('nilai_non_angka', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_kriteria_wilayah');
    }
};
