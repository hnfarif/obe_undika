<?php

namespace App\Http\Controllers;

use App\Exports\MonevExport;
use App\Models\Fakultas;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\KriteriaMonev;
use App\Models\PlottingMonev;
use App\Models\Prodi;
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

        $plot = PlottingMonev::where('semester', '221')->whereHas('insMonev')->with('insMonev')->get();

        $manipulate = tap($plot)->transform(function($data){
            $data->detail = $data->insMonev->detailMonev;
            return $data;
        });

        return [
            'manipulate' => $manipulate,
            'count' => $manipulate->count(),
        ];
    }
}
