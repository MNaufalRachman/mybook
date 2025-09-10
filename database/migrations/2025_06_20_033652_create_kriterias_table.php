<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Menjalankan migration: membuat tabel 'kriterias'
     */
    public function up(): void
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama kriteria (misal: Harga, Tahun Terbit)
            $table->float('bobot'); // Bobot antara 0 - 1
            $table->enum('atribut', ['benefit', 'cost']); // Tipe kriteria
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Mengembalikan migration (drop table)
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
