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
        $maku = MataKuliah::where('id', $prodi.$mk)->first();

        return $maku->nama;
    }


    public function getNameProdi($prodi)
    {
        $prodi = Prodi::where('id', $prodi)->first();

        return $prodi->nama;
    }

    public function getNameKary($nik)
    {
        $kary = KaryawanDosen::where('nik', $nik)->first();

        return $kary->nama;
    }
}
