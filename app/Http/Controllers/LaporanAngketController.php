<?php

namespace App\Http\Controllers;

use App\Models\AngketTrans;
use App\Models\Fakultas;
use App\Models\KaryawanDosen;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Http\Request;

class LaporanAngketController extends Controller
{
    public function index()
    {
        $angket = AngketTrans::with('karyawan')->fakultas()->prodi()->dosen()->get();
        $smt = Semester::all();
        $fak = Fakultas::with('prodis')->get();
        $prodi = Prodi::all();
        $kary = KaryawanDosen::all();


        $filterAngket = $angket->filter(function ($angket) use ($smt) {
            $semester = $smt->where('fak_id', $angket->prodi)->first();

            return $angket->smt == $semester->smt_aktif;
        });



        return view('laporan.angket.index', compact('filterAngket', 'fak', 'prodi', 'kary' ));
    }
}
