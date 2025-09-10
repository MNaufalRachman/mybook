<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kriteria;

class SubKriteria extends Model
{
    protected $fillable = [
        'kriteria_id',
        'batas_awal',
        'batas_akhir',
        'nilai',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
