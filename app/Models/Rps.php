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

    public function scopeFakultas($query)
    {
        if (request()->fakultas) {
            $prodi = Prodi::whereIn('id_fakultas', request()->fakultas)->pluck('id')->toArray();
            return $query->where(function ($q) use ($prodi) {
                foreach ($prodi as $key => $value) {
                    $q->orWhere('kurlkl_id', 'LIKE', $value . '%');
                }
            });
        }

    }

    public function scopeProdi($query)
    {
        if (request()->prodi) {
            // $arr = request()->prodi->toArray();
            $filProdi = request()->prodi;

            return $query->where(function ($q) use ($filProdi) {
                foreach ($filProdi as $key => $value) {
                    $q->orWhere('kurlkl_id', 'LIKE', $value . '%');
                }
            });
        }

    }

    public function scopeName($query)
    {
        if (request()->search) {
            return $query->where('nama_mk', 'LIKE', '%' . request('search') . '%');
        }
    }

    public function scopeStatus($query)
    {
        if (request()->status) {
            return $query->where('is_done', request('status'));
        }
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
