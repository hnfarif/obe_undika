<?php

namespace App\Http\Controllers;

use App\Exports\MonevExport;
use App\Models\Fakultas;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\KriteriaMonev;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Excel;

class LaporanMonevController extends Controller
{

    public function index()
    {

        // data filters
        $fak = Fakultas::all();
        $prodi = Prodi::all();
        $kary = KaryawanDosen::all();

        // dd(request()->all());
        $fakul = Fakultas::with('prodis')->get();
        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        $jdw = JadwalKuliah::with('matakuliahs', 'karyawans')->fakultas()->prodi()->dosen()->get();
        return view('laporan.monev.index', compact('kri', 'jdw', 'fak', 'prodi', 'kary', 'fakul'));
    }

    public function exportExcel()
    {
        $nama_file = 'monev_kriteria_3_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new MonevExport, $nama_file);
    }

}
