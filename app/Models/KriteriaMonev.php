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
    public function getNilaiKri3($nik, $mk, $prodi)
    {
        // $data = [];
        // $smt = Semester::where('fak_id', $prodi)->first();
        // $insNilai = InstrumenNilai::where('klkl_id', $mk)->where('semester', $smt->smt_aktif)->where('nik', $nik)->first();
        // $dtlNilai = DetailInstrumenNilai::where('ins_nilai_id', $insNilai->id)->get();
        // $unique = $dtlNilai->distinct('dtl_agd_id')->pluck('dtl_agd_id')->toArray();

        // $dtlAgd = DetailAgenda::whereIn('id', $unique)->get();
        // $uniClo = $dtlAgd->distinct('clo_id');

        // foreach ($uniClo as $u) {
        //     $da = $dtlAgd->where('clo_id', $u->id)->pluck('id')->toArray();
        //     $arrNilai = $dtlNilai->whereIn('dtl_agd_id', $da)->get();
        //     $sumBobot = $dtlAgd->where('clo_id', $u->id)->sum('bobot');
        //     foreach ($arrNilai as $n) {
        //         $bobot = $dtlAgd->where('id', $n->dtl_agd_id)->first()->bobot;
        //         $res =+ $n->nilai * ($bobot / 100);
        //     }
        //     $nKonv = number_format($res / $sumBobot, 2);
        //     if (round($nKonv) >= $insNilai->nilai_min_mk) {
        //         $sts = 'L';
        //     }


        // }
        return '-';

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

}
