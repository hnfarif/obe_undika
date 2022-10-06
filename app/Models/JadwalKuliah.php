<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;


    protected $table = 'jdwkul_mf';

    // protected $appends = ['nameMatakuliah'];

    public function matakuliahs()
    {
        return $this->belongsTo(MataKuliah::class, 'id', 'klkl_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'fak_id', 'prodi');
    }
    public function karyawans()
    {
        return $this->belongsTo(KaryawanDosen::class, 'kary_nik', 'nik');
    }

    public function getNameMataKuliah($kdMk, $kdProdi)
    {
        $maku = MataKuliah::where('id', $kdProdi.$kdMk)->first();

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

    public function getNilaiKri1($nik, $mk, $prodi, $kriteria)
    {
        $smt = Semester::where('fak_id', $prodi)->first();
        $plot = PlottingMonev::where('nik_pengajar', $nik)
            ->where('klkl_id', $mk)
            ->where('prodi', $prodi)
            ->where('semester', $smt->smt_aktif)
            ->first();
        $insMon = InstrumenMonev::where('plot_monev_id', $plot->id)->first();
        $dtlMon = DetailInstrumenMonev::where('ins_monev_id', $insMon->id)->where('id_kri', $kriteria)->sum('nilai');
        $insNilai = InstrumenNilai::where('id', $insMon->ins_nilai_id)->first();
        $agd = AgendaBelajar::where('rps_id', $insNilai->rps_id)->pluck('id')->toArray();
        $count = DetailAgenda::whereIn('agd_id', $agd)->where('penilaian_id','<>', null)->count();


        return $count == 0 ? 0 : number_format($dtlMon / $count, 2);
    }
    public function getNilaiKri2($nik, $mk, $prodi, $kriteria)
    {
        $smt = Semester::where('fak_id', $prodi)->first();
        $plot = PlottingMonev::where('nik_pengajar', $nik)
            ->where('klkl_id', $mk)
            ->where('prodi', $prodi)
            ->where('semester', $smt->smt_aktif)
            ->first();
        $insMon = InstrumenMonev::where('plot_monev_id', $plot->id)->first();
        $dtlMon = DetailInstrumenMonev::where('ins_monev_id', $insMon->id)->where('id_kri', $kriteria)->sum('nilai');
        $nilai = number_format($dtlMon / 14 * 100, 2);

        $eval = 0;
        if ($nilai > 80) {

            $eval = 4;
        } else if ($nilai <= 80 && $nilai > 70) {

            $eval = 3;
        } else if ($nilai <= 70 && $nilai > 60) {

            $eval = 2;
        } else if ($nilai <= 60 && $nilai > 50) {

            $eval = 1;
        } else if ($nilai <= 50) {
            $eval = 0;
        }


        return $eval;

    }
    public function getNilaiKri3($nik, $mk, $prodi, $kls)
    {
        $nilaiBbt = [];
        $nilaiperClo = [];
        $smt = Semester::where('fak_id', $prodi)->first();
        $insNilai = InstrumenNilai::where('klkl_id', $mk)->where('semester', $smt->smt_aktif)->where('nik', $nik)->first();
        $countClo = Clo::where('rps_id', $insNilai->rps_id)->count();
        $dtlNilai = DetailInstrumenNilai::where('ins_nilai_id', $insNilai->id)->get();
        $countMhs = Krs::where('jkul_klkl_id', $mk)->where('kary_nik', $nik)->where('jkul_kelas', $kls)->count();
        $countPresensi = Krs::where('jkul_klkl_id', $mk)->where('kary_nik', $nik)->where('jkul_kelas', $kls)->where('sts_pre', '1')->count();
        $sumLulus = 0;

        foreach ($dtlNilai as $dn) {
            $bbt = DetailAgenda::where('id', $dn->dtl_agd_id)->first();
            $nbbt = $dn->nilai * ($bbt->bobot / 100);
            $nilaiBbt[$dn->mhs_nim][$bbt->clo_id][$dn->dtl_agd_id] = $nbbt;
        }

        foreach ($nilaiBbt as $mhs => $clos) {
            foreach ($clos as $clo => $nilaiClo) {
                $sumBobot = DetailAgenda::where('clo_id', $clo)->sum('bobot');
                $nilaiMin = Clo::where('id', $clo)->first();
                if($sumBobot == 0){
                    $sumBobot = 1;
                }
                $nilaiKonv = (array_sum($nilaiClo) / $sumBobot)*100;

                if (round($nilaiKonv) >= $nilaiMin->nilai_min) {

                    $nilaiperClo[$mhs][$clo] = 'L';
                }else{
                    $nilaiperClo[$mhs][$clo] = 'TL';
                }
            }
        }

        foreach ($nilaiperClo as $clo) {
            if (count($clo) == $countClo) {
                if(count(array_filter($clo, function ($value) { return $value === 'L'; })) == $countClo){
                    $sumLulus++;
                }
            }
        }

        $ilc = $this->divnum($sumLulus, ($countMhs - $countPresensi));
        $eval = number_format($ilc * 4, 2);

        return $eval;

    }

    public function getNilaiAkhir($nik, $mk, $prodi, $kls)
    {
        $na = 0;
        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        foreach ($kri as $key => $k) {
            if($key == 0){

                $na += $this->getNilaiKri1($nik, $mk, $prodi, $k->id) * ($k->bobot/100);
            }elseif($key == 1){

                $na += $this->getNilaiKri2($nik, $mk, $prodi, $k->id) * ($k->bobot/100);
            }elseif($key == 2){

                $na += $this->getNilaiKri3($nik, $mk, $prodi, $kls) * ($k->bobot/100);
            }
        }

        return number_format($na, 2);
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
