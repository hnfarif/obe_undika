<?php

namespace App\Http\Controllers;

use App\Exports\MonevExport;
use App\Models\AngketTrans;
use App\Models\DetailAgenda;
use App\Models\Fakultas;
use App\Models\InstrumenNilai;
use App\Models\JadwalKuliah;
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
    private $semester;

    public function __construct()
    {
        $this->semester = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
    }

    public function index()
    {
        $prodi = Prodi::where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::where('fakul_id', '<>', null)->where('kary_type', 'like', '%D%')->get();
        $fakul = Fakultas::with('prodis')->get();
        $fak = $fakul;

        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        $smt = $this->semester;
        $plot = PlottingMonev::whereSemester('221')->whereHas('insMonev')->with('insMonev')->get();
        // $filKlkl = $plot->pluck('klkl_id')->toArray();
        // $filNik = $plot->pluck('nik_pengajar')->toArray();
        // $jdw = JadwalKuliah::whereIn('klkl_id', $filKlkl)->whereIn('kary_nik', $filNik)->with( 'karyawan')->fakultas()->prodi()->dosen()->get();
        return view('laporan.monev.index', compact('kri', 'fak', 'prodi', 'kary', 'fakul', 'smt'));
    }

    public function exportExcel()
    {
        $nama_file = 'monev_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new MonevExport, $nama_file);
    }

    public function exportPdf()
    {
        if (request()->has('prodi')) {
            $filProdi = Prodi::whereIn('id', request('prodi'))->get();
        } else {
            $filProdi = Prodi::where('sts_aktif', 'Y')->get();
        }

        $smt = $this->semester;
        $plot = PlottingMonev::whereSemester($smt)->whereHas('insMonev')->get();
        $filKlkl = $plot->pluck('klkl_id')->toArray();
        $filNik = $plot->pluck('nik_pengajar')->toArray();

        $pdf = PDF::loadView('laporan.monev.export-pdf', ['fakul' => Fakultas::with('prodis')->get(),
        'kri' => KriteriaMonev::orderBy('id', 'asc')->get(),
        'jdw' => JadwalKuliah::whereIn('klkl_id', $filKlkl)->whereIn('kary_nik', $filNik)->with('matakuliahs', 'karyawans')->fakultas()->prodi()->dosen()->get(),
        'prodi' => $filProdi,
        'smt' => $smt
        ]);

        return $pdf->stream('laporan_monev_'.date('Y-m-d_H-i-s').'.pdf');
    }

    public function manipulateMonev($plot, $kri){

        $plot = tap($plot)->transform(function($data) use ($kri){
            foreach ($kri as $k) {
                $data->kri.'_'.$k->id = $data->insMonev->detailMonev->where('kri_id', $k->id)->sum('nilai');
            }
        });
    }

    public function cekData()
    {

        $plot = PlottingMonev::whereSemester('221')->whereHas('insMonev')->with('insMonev')->get();
        $rps = Rps::whereIn('kurlkl_id', $plot->unique('klkl_id')->pluck('klkl_id')->toArray())->with('clos')->get();
        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        $krs = Krs::whereIn('jkul_klkl_id', $plot->unique('klkl_id')->pluck('klkl_id')->toArray())->where('jkul_kelas', $plot->unique('kelas')->pluck('kelas')->toArray())->get();
        $insNilai = InstrumenNilai::whereIn('klkl_id', $plot->unique('klkl_id')->pluck('klkl_id')->toArray())->whereSemester('221')->with('detailNilai')->first();
        $dtlAgd = DetailAgenda::whereIn('clo_id', $rps->pluck('clos.*.id')->flatten()->toArray())->get();

        $manipulate = tap($plot)->transform(function($data) use ($rps, $kri, $krs, $insNilai, $dtlAgd){
            $data->detail = $data->insMonev->detailMonev;
            foreach($rps as $r){
                foreach($r->agendabelajars as $ag){
                    $data->jumlah_penilaian += $ag->detailAgendas->where('penilaian_id', '<>', null)->count();
                }
            }
            foreach ($kri as $key => $k) {
               if ($key == 0) {

                    $data->kri_1 = $data->jumlah_penilaian == 0 ? 0 : number_format($data->insMonev->detailMonev->where('kri_id', $k->id)->sum('nilai') / $data->jumlah_penilaian, 2);

                } else if ($key == 1) {
                    $nilai = number_format(($data->insMonev->detailMonev->where('kri_id', $k->id)->sum('nilai') / 14) * 100, 2);

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

                    if($sumBobot == 0){
                        $sumBobot = 1;
                    }

                    $nilaiKonv = (array_sum($nilaiClo) / $sumBobot)*100;

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
            return $data;
        });

        return [
            'manipulate' => $manipulate,
            'count' => $manipulate->count(),
        ];
    }
}
