<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilBukuTerminat extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'hasil_buku_terminats';

    /**
     * Kolom yang dapat diisi secara massal
     */
    protected $fillable = [
        'alternatif_id',
        'rank',           // Ranking dari hasil VIKOR
        'judul',
        'pengarang',
        'tahun_terbit',
        'kategori',
        'jumlah',         // Jumlah peminjaman
        'Q',              // Nilai Q (hasil VIKOR)
        'tahun_hasil',    // Tahun hasil terminat dihitung
        'harga',          // Harga buku
    ];

    /**
     * Relasi ke model Alternatif
     */
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
}
