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

    public function matakuliahs()
    {
        return $this->belongsTo(MataKuliah::class, 'id', 'klkl_id');
    }

    public function karyawans()
    {
        return $this->belongsTo(KaryawanDosen::class, 'kary_nik', 'nik');
    }

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

    public function nikKaryawanMonev()
    {
        return $this->hasMany(PlottingMonev::class, 'nik_pengajar', 'kary_nik');
    }

    public function mkKaryawanMonev()
    {
        return $this->hasMany(PlottingMonev::class, 'klkl_id', 'klkl_id');
    }

    public function cekKriteria($nik, $mk, $prodi)
    {
        $smt = Semester::where('fak_id', $prodi)->first();
        $plot = PlottingMonev::where('nik_pengajar', $nik)
            ->where('klkl_id', $mk)
            ->where('prodi', $prodi)
            ->where('semester', $smt->smt_aktif)
            ->first();
        if ($plot) {
            $insMon = InstrumenMonev::where('plot_monev_id', $plot->id)->first();
            if ($insMon) {
                return 'ada';
            }else{
                return 'insMon';
            }

        }else{
            return 'plot';
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
            // $arr = request()->prodi->toArray();
            return $query->whereIn('prodi', request('prodi'));
        }

    }

    public function scopeDosen($query)
    {
        if (request()->dosen) {
            return $query->whereIn('kary_nik', request('dosen'));
        }
    }
}
