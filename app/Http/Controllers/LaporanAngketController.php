<?php

namespace App\Http\Controllers;

use App\Models\AngketTrans;
use App\Models\Fakultas;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\Semester;
use PDF;
use Illuminate\Http\Request;

class LaporanAngketController extends Controller
{
    public function index()
    {
        $fak = Fakultas::where('sts_aktif', 'Y')->get();
        $arrFak = $fak->pluck('id')->toArray();
        $prodi = Prodi::whereIn('id_fakultas', $arrFak)->where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::where('kary_type', 'like', '%D%')->get();

        $angket = $this->manipulateDataAngket();

        dd($angket);

        return view('laporan.angket.index', compact('angket', 'fak', 'prodi', 'kary' ));
    }

    public function manipulateDataAngket(){

        $smt = Semester::orderBy('smt_yad', 'desc')->first();
        $jdwkul = JadwalKuliah::all();
        $angket = AngketTrans::where('smt', $smt->smt_yad)->where('kode_mk', )->get();

        $rataAngket = [];

        foreach ($jdwkul as $j) {
            if ($j->matakuliahs) {
                $sumDosen = $angket->where('nik', $j->kary_nik)->sum('nilai');
                $cnDosen = $angket->where('nik', $j->kary_nik)->count();
                $rataDosen = $sumDosen / $cnDosen;

                $sumMk = $angket->where('nik', $j->kary_nik)->where('kode_mk', $j->klkl_id)->where('kelas', $j->kelas)->sum('nilai');
                $cnMk = $angket->where('nik', $j->kary_nik)->where('kode_mk', $j->klkl_id)->where('kelas', $j->kelas)->count();
                $rataMk = $sumMk / $cnMk;


                $rataAngket[$j->kary_nik] = [
                    'nama' => $j->karyawans->nama,
                    'rata_dosen' => $rataDosen,
                    'kode_mk' => [
                        $j->klkl_id => [
                            'nama' => $j->matakuliahs->nama,
                            'kelas' => $j->kelas,
                            'rata_mk' => $rataMk,
                        ],
                    ],

                ];
            }


        }


        return $rataAngket;
    }

    public function exportPdf()
    {
        if (request()->has('prodi')) {
            $filProdi = Prodi::whereIn('id', request('prodi'))->get();
        } else {
            $filProdi = null;
        }

        $angket = AngketTrans::with('karyawan')->fakultas()->prodi()->dosen()->get();
        $smt = Semester::orderBy('smt_yad', 'desc')->first();
        $fak = Fakultas::with('prodis')->get();


        $filterAngket = $angket->filter(function ($angket) use ($smt) {

            return $angket->smt == $smt->smt_yad;
        });

        $pdf = PDF::loadView('laporan.angket.export-pdf', ['fak' => $fak,
        'filterAngket' => $filterAngket,
        'prodi' => $filProdi
        ]);

        return $pdf->stream('laporan_angket_'.date('Y-m-d_H-i-s').'.pdf');
    }
}
