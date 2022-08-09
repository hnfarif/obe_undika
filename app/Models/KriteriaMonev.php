<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaMonev extends Model
{
    use HasFactory;

    protected $table = 'kri_monev';
    protected $guarded = ['id'];

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
        $count = DetailInstrumenMonev::where('ins_monev_id', $insMon->id)->where('id_kri', $kriteria)->count();
        $nilai = number_format($dtlMon / $count, 2);
        return $nilai;


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
        if ($nilai > 80) {
            return '4';
        } else if ($nilai <= 80 && $nilai > 70) {

            return '3';
        } else if ($nilai <= 70 && $nilai > 60) {

            return '2';
        } else if ($nilai <= 60 && $nilai > 50) {

            return '1';
        } else if ($nilai <= 50) {
            return '0';
        }

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
        $ilc = $sumLulus / ($countMhs - $countPresensi);
        $eval = number_format($ilc * 4, 2);

        return $eval;

    }


}
