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
        Schema::create('wilayah_kelurahan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelurahan');
            $table->foreignId('wilayah_kecamatan_id')->constrained('wilayah_kecamatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah_kelurahan');
    }
};
