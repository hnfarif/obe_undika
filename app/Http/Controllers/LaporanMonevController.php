<?php

namespace App\Http\Controllers;

use App\Models\JadwalKuliah;
use App\Models\KriteriaMonev;
use Illuminate\Http\Request;

class LaporanMonevController extends Controller
{

    public function index()
    {
        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        $jdw = JadwalKuliah::with('matakuliahs', 'karyawans')->get();
        return view('laporan.monev', compact('kri', 'jdw'));
    }

}
