<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumenNilai extends Model
{
    use HasFactory;

    protected $table = 'instrumen_nilai';
    protected $guarded = ["id"];

    public function karyawan()
    {
        return $this->belongsTo(KaryawanDosen::class, 'nik', 'nik');
    }
}
