<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlottingMonev extends Model
{
    use HasFactory;

    protected $table = 'plot_monev';
    protected $guarded = ["id"];

    public function getNameMataKuliah($mk, $prodi)
    {
        $maku = MataKuliah::where('id', $prodi.$mk)->first();

        return $maku->nama;
    }

    public function getKelasRuang($mk, $nik)
    {
        $maku = JadwalKuliah::where('klkl_id', $mk)->where('kary_nik', $nik)->first();

        return ['kelas' => $maku->kelas, 'ruang' => $maku->ruang_id];
    }

    public function getNameKary($nik)
    {
        $kary = KaryawanDosen::where('nik', $nik)->first();

        return $kary->nama;
    }
}