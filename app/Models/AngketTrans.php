<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketTrans extends Model
{
    use HasFactory;

    protected $table = 'angket_tf';
    public $incrementing = false;

    public function karyawan()
    {
        return $this->belongsTo(KaryawanDosen::class, 'nik', 'nik');
    }

    public function matakuliah(){
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'id');
    }

    public function getMatakuliahName($mk)
    {
        $mk = MataKuliah::where('id', $mk)->first();
        return $mk->nama;
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
