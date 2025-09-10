<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hasil_buku_terminats', function (Blueprint $table) {
            $table->id();
            $table->integer('rank')->nullable(); // Kolom ranking di atas judul
            $table->unsignedBigInteger('alternatif_id')->nullable();
            $table->string('judul');
            $table->string('pengarang')->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('kategori')->nullable();
            $table->decimal('harga', 10, 2)->nullable(); // Harga buku
            $table->integer('jumlah')->nullable(); // Jumlah peminjaman
            $table->float('Q')->nullable();        // Nilai Q
            $table->year('tahun_hasil');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_buku_terminats');
    }
};
