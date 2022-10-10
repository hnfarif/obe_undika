<?php

namespace App\Http\Controllers;

use App\Models\AngketTrans;
use App\Models\Fakultas;
use App\Models\KaryawanDosen;
use App\Models\Prodi;
use App\Models\Semester;
use PDF;
use Illuminate\Http\Request;

class LaporanAngketController extends Controller
{
    public function index()
    {
        $angket = AngketTrans::with('karyawan')->fakultas()->prodi()->dosen()->get();
        $smt = Semester::all();
        $fak = Fakultas::with('prodis')->get();
        $prodi = Prodi::where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::all();


        $filterAngket = $angket->filter(function ($angket) use ($smt) {
            $semester = $smt->where('fak_id', $angket->prodi)->first();

            return $angket->smt == $semester->smt_yad;
        });



        return view('laporan.angket.index', compact('filterAngket', 'fak', 'prodi', 'kary' ));
    }

    public function exportPdf()
    {
        if (request()->has('prodi')) {
            $filProdi = Prodi::whereIn('id', request('prodi'))->get();
        } else {
            $filProdi = null;
        }

        $angket = AngketTrans::with('karyawan')->fakultas()->prodi()->dosen()->get();
        $smt = Semester::all();
        $fak = Fakultas::with('prodis')->get();


        $filterAngket = $angket->filter(function ($angket) use ($smt) {
            $semester = $smt->where('fak_id', $angket->prodi)->first();

            return $angket->smt == $semester->smt_yad;
        });

        $pdf = PDF::loadView('laporan.angket.export-pdf', ['fak' => $fak,
        'filterAngket' => $filterAngket,
        'prodi' => $filProdi
        ]);

        return $pdf->stream('laporan_angket_'.date('Y-m-d_H-i-s').'.pdf');
    }
}
