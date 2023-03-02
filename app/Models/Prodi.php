<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'fak_mf';
    public $incrementing = false;



    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas');
    }
    public function karyawans()
    {
        return $this->hasMany(KaryawanDosen::class);
    }

    public function matakuliahs()
    {
        return $this->hasMany(Matakuliah::class);
    }

    public function peos()
    {
        return $this->hasMany(Peo::class);
    }

    public function scopeId($query)
    {
        if (request()->prodi) {
            return $query->whereIn('id', request('prodi'));
        }
    }

    public function getAvgMonev($prodi, $smt)
    {

        $jdw = JadwalKuliah::with('karyawan')->where('prodi', $prodi)->get();
        $count = 0;
        $sum = 0;
        foreach ($jdw as $j) {
            if ($j->cekKriteria($j->kary_nik, $j->klkl_id, $j->prodi, $j->kelas, $smt) == 'ada') {
                $count++;
                $sum += $j->getNilaiAkhir($j->kary_nik, $j->klkl_id, $j->prodi, $j->kelas, $smt);
            }
        }

        $njdw = new JadwalKuliah();
        $avg = $njdw->divnum($sum, $count);
        return number_format($avg, 2);

    }

}
