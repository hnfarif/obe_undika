<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rps extends Model
{
    use HasFactory;

    protected $table = 'rps';
    protected $guarded = ["id"];
    protected $primaryKey = 'id';

    public function clos()
    {
        return $this->hasMany(Clo::class)->orderBy('id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kurlkl_id', 'id');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class)->orderBy('id');
    }

    public function agendabelajars()
    {
        return $this->hasMany(AgendaBelajar::class);
    }
    public function karyawan()
    {
        return $this->belongsTo(KaryawanDosen::class, 'nik', 'nik');
    }

    public function getAllTotal($pens, $clos)
    {
        $total = 0;

        foreach ($clos as $c) {
            foreach ($pens as $p) {

                $total += DetailAgenda::where('clo_id', $c->id)->where('penilaian_id', $p->id)->sum('bobot');

            }
        }

        return $total;
    }
}
