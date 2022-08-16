<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\KriteriaMonev;
use App\Models\Prodi;
use Illuminate\Http\Request;

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

}
