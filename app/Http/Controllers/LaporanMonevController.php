<?php

namespace App\Http\Controllers;

use App\Exports\MonevExport;
use App\Models\DetailAgenda;
use App\Models\Fakultas;
use App\Models\InstrumenNilai;
use App\Models\KaryawanDosen;
use App\Models\KriteriaMonev;
use App\Models\Krs;
use App\Models\MataKuliah;
use App\Models\PlottingMonev;
use App\Models\Prodi;
use App\Models\Rps;
use App\Models\Semester;
use Excel;
use PDF;

class LaporanMonevController extends Controller
{
    private $semester, $fakul, $kri;
    public function __construct()
    {
        $this->semester = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
        $this->kri =  KriteriaMonev::orderBy('id', 'asc')->get();
        $this->fakul = Fakultas::where('sts_aktif', 'Y')->with('prodis')->get();
    }

    public function index()
    {
        $prodi = Prodi::where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::where('fakul_id', '<>', null)->where('kary_type', 'like', '%D%')->get();
        $fakul = $this->fakul;
        $fak = $this->fakul;

        $kri = $this->kri;
        $smt = $this->semester;

        $dataMonev = $this->manipulateMonev();
        $rata_fak = $this->manipulateSummary($dataMonev);


        return view('laporan.monev.index', compact('kri', 'fak', 'prodi', 'kary', 'fakul', 'dataMonev', 'rata_fak', 'smt'));
    }

    public function exportExcel()
    {
        $nama_file = 'monev_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new MonevExport, $nama_file);
    }

    public function exportPdf()
    {
        $smt = $this->semester;
        $monev = $this->manipulateMonev();
        $rata_fak = $this->manipulateSummary($monev);

        $pdf = PDF::loadView('laporan.monev.export-pdf', ['rata_fak' => $rata_fak,
        'kri' => $this->kri,
        'fak' => $this->fakul,
        'monev' => $monev,
        'smt' => $smt
        ]);

        return $pdf->stream('laporan_monev_'.date('Y-m-d_H-i-s').'.pdf');
    }

    public function manipulateMonev(){
        if (request()->has('semester')) {
            $this->semester = request('semester');
        }
        $plot = PlottingMonev::whereSemester($this->semester)->whereHas('insMonev')->with('insMonev','karyawan', 'dosenPemonev','programstudi')->fakultas()->prodi()->semester()->get();
        $rps = Rps::whereIn('kurlkl_id', $plot->unique('klkl_id')->pluck('klkl_id')->toArray())->with('clos','agendabelajars')->get();
        $krs = Krs::whereIn('jkul_klkl_id', $plot->unique('klkl_id')->pluck('klkl_id')->toArray())->get();
        $insNilai = InstrumenNilai::whereIn('klkl_id', $plot->unique('klkl_id')->pluck('klkl_id')->toArray())->whereSemester($this->semester)->with('detailNilai')->first();
        $dtlAgd = DetailAgenda::whereIn('clo_id', $rps->pluck('clos.*.id')->flatten()->toArray())->with('clo')->get();
        $kri = $this->kri;

        $manipulate = tap($plot)->transform(function($data) use ($rps, $kri, $krs, $insNilai, $dtlAgd){
            foreach($rps as $r){
                foreach($r->agendabelajars as $ag){
                    $data->jumlah_penilaian += $ag->detailAgendas->where('penilaian_id', '<>', null)->count();
                }
            }
            foreach ($kri as $key => $k) {
               if ($key == 0) {

                    $data->kri_1 = ($data->jumlah_penilaian == 0) ? 0 : number_format($data->insMonev->detailMonev->where('id_kri', $k->id)->sum('nilai') / $data->jumlah_penilaian, 2);

                } else if ($key == 1) {
                    $nilai = number_format(($data->insMonev->detailMonev->where('id_kri', $k->id)->sum('nilai') / 14) * 100, 2);

                    if ($nilai > 80) {
                        $data->kri_2 = 4;

                    } else if ($nilai <= 80 && $nilai > 70) {
                        $data->kri_2 = 3;

                    } else if ($nilai <= 70 && $nilai > 60) {
                        $data->kri_2 = 2;

                    } else if ($nilai <= 60 && $nilai > 50) {
                        $data->kri_2 = 1;

                    } else if ($nilai <= 50) {
                        $data->kri_2 = 0;
                    }
               }
            }
            $getRps = $rps->where('kurlkl_id', $data->klkl_id)->first();
            $countClo = $getRps->clos->count();

            $getKrs = $krs->where('jkul_klkl_id', $data->klkl_id)->where('jkul_kelas', $data->kelas);
            $countMhs = $getKrs->count();
            $countPre = $getKrs->where('sts_pre', '1')->count();

            $getInsNilai = $insNilai->where('klkl_id', $data->klkl_id)->whereNik($data->nik_pengajar)->first();

            $nilaiBbt = [];
            $nilaiperClo = [];
            $sumLulus = 0;

            foreach($getInsNilai->detailNilai as $dn){
                $nbbt = $dn->nilai * ($dn->detailAgenda->bobot / 100);
                $nilaiBbt[$dn->mhs_nim][$dn->detailAgenda->clo_id][$dn->dtl_agd_id] = $nbbt;
            }

            foreach ($nilaiBbt as $mhs => $clos) {
                foreach ($clos as $clo => $nilaiClo) {
                    $sumBobot = $dtlAgd->where('clo_id', $clo)->sum('bobot');
                    $getClo = $dtlAgd->where('clo_id', $clo)->first();
                    $nilaiMin = $getClo->clo->nilai_min;

                    $nilaiKonv = ($sumBobot == 0) ? 0 : (array_sum($nilaiClo) / $sumBobot)*100;

                    if (round($nilaiKonv) >= $nilaiMin) {

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

            $ilc = ($countMhs - $countPre == 0) ? 0 : $sumLulus / ($countMhs - $countPre);
            $eval = number_format($ilc * 4, 2);

            $data->kri_3 = $eval;

            $na = 0;
            foreach ($kri as $key => $k) {
                if($key == 0){
                    $na += $data->kri_1 * ($k->bobot/100);
                }elseif($key == 1){

                    $na += $data->kri_2 * ($k->bobot/100);
                }elseif($key == 2){

                    $na += $data->kri_3 * ($k->bobot/100);
                }
            }

            $data->na = number_format($na, 2);
            return $data;
        });

        return $manipulate;
    }

    public function manipulateSummary($plot){
        $fak = $this->fakul;
        if ($plot) {
            $rata_fak = tap($fak)->transform(function($data) use ($plot){
                $jmlPro = $data->prodis->count();
                foreach ($plot as $p) {
                    if ($data->id == $p->programstudi->id_fakultas) {
                        $data->rata += $p->na;
                    }
                }

                $data->rata = $jmlPro == 0 ? 0 : number_format($data->rata / $jmlPro, 2);

                tap($data->prodis)->transform(function($prodi) use ($plot){
                    $jmlMonev = 0;
                    foreach ($plot as $a) {
                        if ($prodi->id == $a->prodi) {
                            $prodi->rata += $a->na;
                            $jmlMonev += 1;
                        }
                    }
                    $prodi->rata = $jmlMonev == 0 ? 0 : number_format($prodi->rata / $jmlMonev, 2);
                    return $prodi;
                });
                return $data;
            });
        }else{
            $rata_fak = tap($fak)->transform(function($data){
                $data->rata = 0;
                tap($data->programstudi)->transform(function($prodi){
                    $prodi->rata = 0;
                    return $prodi;
                });
                return $data;
            });
        }

        return $rata_fak;
    }

    public function cekData()
    {
        $cek = MataKuliah::all();

        return [
            'data' => $cek,
            'count' => $cek->count(),
        ];
    }
}
