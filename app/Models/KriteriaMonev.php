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
        if ($plot) {
            $insMon = InstrumenMonev::where('plot_monev_id', $plot->id)->first();
            if ($insMon) {
                $dtlMon = DetailInstrumenMonev::where('ins_monev_id', $insMon->id)->where('id_kri', $kriteria)->sum('nilai');
                $rps = Rps::where('kurlkl_id', $prodi.$mk)->where('semester', $smt->smt_aktif)->first();
                $agd = AgendaBelajar::where('rps_id', $rps->id)->pluck('id')->toArray();
                $dtlAgd = DetailAgenda::whereIn('agd_id', $agd)->where('penilaian_id', '<>', null)->count();

                return ($dtlMon/$dtlAgd);
            }else{
                return 'Instrumen monev belum dibuat';
            }

        }else{
            return 'Plotting Belum dibuat';
        }


    }

}
