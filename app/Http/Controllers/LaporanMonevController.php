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
use Illuminate\Http\Request;
use Excel;
use PDF;

class LaporanMonevController extends Controller
{

    public function index()
    {

        // data filters
        $fak = Fakultas::all();
        $prodi = Prodi::where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::all();

        // dd(request()->all());
        $fakul = Fakultas::with('prodis')->get();
        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        $smt = Semester::orderBy('smt_yad', 'desc')->first();
        $plot = PlottingMonev::whereSemester($smt->smt_yad)->pluck('klkl_id')->toArray();
        $jdw = JadwalKuliah::whereIn('klkl_id', $plot)->with('matakuliahs', 'karyawans')->fakultas()->prodi()->dosen()->get();
        return view('laporan.monev.index', compact('kri', 'jdw', 'fak', 'prodi', 'kary', 'fakul'));
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

        $pdf = PDF::loadView('laporan.brilian.export-pdf', ['fakul' => Fakultas::with('prodis')->get(),
        'kri' => KriteriaMonev::orderBy('id', 'asc')->get(),
        'jdw' => JadwalKuliah::with('matakuliahs', 'karyawans')->fakultas()->prodi()->dosen()->get(),
        'prodi' => $filProdi
        ]);



        return $pdf->stream('laporan_monev_'.date('Y-m-d_H-i-s').'.pdf');
    }

}
