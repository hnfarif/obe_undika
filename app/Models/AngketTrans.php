<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketTrans extends Model
{
    use HasFactory;

    protected $table = 'angket_tf';

    public function karyawan()
    {
        return $this->belongsTo(KaryawanDosen::class);
    }

    public function matakuliah(){
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'id');
    }

    public function getKaryawan($nik)
    {
        $kary = KaryawanDosen::where('nik', $nik)->first();

        if ($kary) {
            return $kary->nama;
        } else {
            return 'dosen belum ada';
        }

    }

    public function getMatakuliahName($kode_mk)
    {
        $mk = MataKuliah::where('id', $kode_mk)->first();

        if ($mk) {
            return $mk->nama;
        } else {
            return 'matakuliah belum ada';
        }

    }

    public function scopeFakultas($query)
    {
        if (request()->fakultas) {
            $prodi = Prodi::whereIn('id_fakultas', request()->fakultas)->pluck('id')->toArray();
            return $query->whereIn('prodi', $prodi);
        }

    }

    public function scopeProdi($query)
    {
        if (request()->prodi) {

            return $query->whereIn('prodi', request('prodi'));
        }

    }

    public function scopeDosen($query)
    {
        if (request()->dosen) {
            return $query->whereIn('nik', request('dosen'));
        }
    }
}
