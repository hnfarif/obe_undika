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

    public function programstudi()
    {
        return $this->belongsTo(Prodi::class, 'prodi', 'id');
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

    public function nikKaryawanJdw()
    {
        return $this->belongsTo(JadwalKuliah::class, 'nik_pengajar', 'kary_nik');
    }

    public function mkKaryawanJdw()
    {
        return $this->belongsTo(JadwalKuliah::class, 'klkl_id', 'klkl_id');
    }

    public function cnPlot($nik, $smt)
    {
        $cn = PlottingMonev::where('semester', $smt)->where('nik_pemonev', $nik)->count();

        return $cn;
    }

    public function scopeDosen($query)
    {
        if (request()->dosen) {
            return $query->whereIn('nik_pemonev', request('dosen'));
        }
    }

    public function scopeProdi($query)
    {
        if (request()->prodi) {
            return $query->whereIn('prodi', request('prodi'));
        }

    }

    public function scopeFakultas($query)
    {
        if (request()->fakultas) {
            $prodi = Prodi::whereIn('id_fakultas', request()->fakultas)->pluck('id')->toArray();
            return $query->whereIn('prodi', $prodi);
        }

    }

    public function scopeName($query)
    {
        if (request()->search) {
            $mk = MataKuliah::selectRaw("SUBSTR(id, 6, 5) as id")->whereRaw('LOWER(nama) LIKE ?', '%' . strtolower(request('search')) . '%')->pluck('id')->toArray();
            return $query->where(function ($q) use ($mk) {
                foreach ($mk as $key => $value) {
                    $q->orWhere('klkl_id', 'LIKE', '%'.$value. '%');
                }
            });
        }
    }
}
