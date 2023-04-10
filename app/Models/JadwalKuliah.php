<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;


    protected $table = 'jdwkul_mf';

    public function matakuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id', 'klkl_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'fak_id', 'prodi');
    }

    public function karyawan()
    {
        return $this->belongsTo(KaryawanDosen::class, 'kary_nik', 'nik');
    }

    public function prodi(){
        return $this->belongsTo(Prodi::class, 'prodi', 'id');
    }

    public function getNameMataKuliah($kdMk)
    {
        $maku = MataKuliah::where('id', $kdMk)->first();

        if ($maku) {
            return $maku->nama;
        }else{
            return '-';
        }

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

    public function divnum($numerator, $denominator)
    {
        return $denominator == 0 ? 0 : ($numerator / $denominator);
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
