<?php

namespace App\Http\Controllers;

use App\Exports\MonevExport;
use App\Models\Fakultas;
use App\Models\InstrumenMonev;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\KriteriaMonev;
use App\Models\PlottingMonev;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Http\Request;
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

        // data filters
        $prodi = Prodi::where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::where('fakul_id', '<>', null)->where('kary_type', 'like', '%D%')->get();

        // dd(request()->all());
        $fakul = Fakultas::with('prodis')->get();
        $fak = $fakul;
        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        $smt = $this->semester;
        $plot = PlottingMonev::whereSemester($smt)->whereHas('insMonev')->get();
        $filKlkl = $plot->pluck('klkl_id')->toArray();
        $filNik = $plot->pluck('nik_pengajar')->toArray();
        $jdw = JadwalKuliah::whereIn('klkl_id', $filKlkl)->whereIn('kary_nik', $filNik)->with('matakuliahs', 'karyawans')->fakultas()->prodi()->dosen()->get();
        return view('laporan.monev.index', compact('kri', 'jdw', 'fak', 'prodi', 'kary', 'fakul', 'smt'));
    }

    public function exportExcel()
    {
        $nama_file = 'monev_kriteria_3_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new MonevExport, $nama_file);
    }

    public function exportPdf()
    {
        if (request()->has('prodi')) {
            $filProdi = Prodi::whereIn('id', request('prodi'))->get();
        } else {
            $filProdi = null;
        }

        $smt = $this->semester;
        $plot = PlottingMonev::whereSemester($smt)->pluck('klkl_id')->toArray();

        $pdf = PDF::loadView('laporan.monev.export-pdf', ['fakul' => Fakultas::with('prodis')->get(),
        'kri' => KriteriaMonev::orderBy('id', 'asc')->get(),
        'jdw' => JadwalKuliah::whereIn('klkl_id', $plot)->with('matakuliahs', 'karyawans')->fakultas()->prodi()->dosen()->get(),
        'prodi' => $filProdi
        ]);



        return $pdf->stream('laporan_monev_'.date('Y-m-d_H-i-s').'.pdf');
    }

}
