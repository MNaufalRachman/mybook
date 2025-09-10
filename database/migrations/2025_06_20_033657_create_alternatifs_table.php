<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Menjalankan migrasi: membuat tabel `alternatifs`
     */
    public function up(): void
    {
        Schema::create('alternatifs', function (Blueprint $table) {
            $table->id(); // ID auto-increment (primary key)
            $table->string('judul'); // Judul buku
            $table->string('pengarang'); // Nama pengarang
            $table->year('tahun_terbit'); // Tahun terbit (format 4 digit)
            $table->string('kategori'); // Kategori buku
            $table->integer('peminjaman'); // Jumlah peminjaman
            $table->integer('koleksi_meja'); // Frekuensi dibaca di tempat
            $table->decimal('harga', 15, 2); // Harga buku
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Membatalkan migrasi: menghapus tabel `alternatifs`
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatifs');
    }
};
