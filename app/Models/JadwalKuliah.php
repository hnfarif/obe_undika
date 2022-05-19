<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;


    protected $table = 'jdwkul_mf';
    protected $guarded = ["kary_nik"];
    public $incrementing = false;
    protected $primaryKey = null;

    public function getNameMataKuliah($mk, $prodi)
    {
        $mk = MataKuliah::where('id', $prodi.$mk)->first();

        return $mk->nama;
    }


    public function getNameProdi($prodi)
    {
        $prodi = Prodi::where('id', $prodi)->first();

        return $prodi->nama;
    }
}
