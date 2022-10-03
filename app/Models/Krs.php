<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;


    protected $table = 'krs_tf';

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_nim', 'nim');
    }
}
