<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    /**
     * Atribut yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',           // Judul buku
        'pengarang',       // Nama pengarang buku
        'tahun_terbit',    // Tahun terbit buku
        'kategori',        // Kategori buku
        'peminjaman',      // Jumlah peminjaman
        'koleksi_meja',    // Jumlah pembacaan di tempat
        'harga',           // Harga buku
    ];
}
