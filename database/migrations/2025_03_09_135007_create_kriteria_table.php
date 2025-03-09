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
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kriteria');
            $table->enum('kategori', ['wilayah', 'sekolah']);
            $table->enum('tipe', ['angka', 'non-angka']);
            $table->string('satuan')->nullable();
            $table->enum('sifat', ['benefit', 'cost']);
            $table->integer('bobot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};
