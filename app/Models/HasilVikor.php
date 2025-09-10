<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilVikor extends Model
{
    protected $fillable = ['alternatif_id', 'judul', 'S', 'R', 'Q', 'rank'];
}
