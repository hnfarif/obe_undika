<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rps extends Model
{
    use HasFactory;

    protected $table = 'rps';
    protected $guarded = ["id"];


    public function clos()
    {
        return $this->hasMany(Clo::class);
    }

    public function matakuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kurlkl_id', 'id');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function agendabelajars()
    {
        return $this->hasMany(AgendaBelajar::class);
    }
    public function karyawan()
    {
        return $this->belongsTo(KaryawanDosen::class, 'nik', 'nik');
    }

}
