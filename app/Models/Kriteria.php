<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara mass assignment
    protected $fillable = [
        'nama',
        'bobot',
        'atribut',
    ];

    /**
     * Relasi: Satu Kriteria memiliki banyak SubKriteria
     */
    public function subkriterias()
    {
        return $this->hasMany(SubKriteria::class);
    }
}
