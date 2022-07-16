<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MingguKuliah extends Model
{
    use HasFactory;

    protected $table = 'minggu_kuliah';
    protected $fillable = ["jenis_smt", "smt", "minggu_ke", "tgl_awal", "tgl_akhir"];
    public $incrementing = false;
    protected $primaryKey = null;
    public $timestamps = false;
}
