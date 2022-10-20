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
        $angket = AngketTrans::where('smt', $smt->smt_yad)->prodi()->dosen()->get();
        $rataAngket = [];

        foreach($angket as $a){

            //check if rataAngket has nik
            if(array_key_exists($a->nik, $rataAngket)){
               //check if rataAngket has kode_mk
               if(array_key_exists($a->kode_mk, $rataAngket[$a->nik]['kode_mk'])){
                    continue;
               }else{
                    $sumNilaiMk = $angket->where('nik', $a->nik)->where('kode_mk', $a->kode_mk)->sum('nilai');
                    $countNilaiMk = $angket->where('nik', $a->nik)->where('kode_mk', $a->kode_mk)->count();
                    $rataAngket[$a->nik]['kode_mk'] = [
                        $a->kode_mk => [
                            'nama_mk' => $a->getMatakuliahName($a->kode_mk),
                            'kelas' => $a->kelas,
                            'rata_mk' => $sumNilaiMk / $countNilaiMk,
                        ]

                    ];
               }

            }else{

                $sumNilai = $angket->where('nik', $a->nik)->sum('nilai');
                $countNilai = $angket->where('nik', $a->nik)->count();

                $rataAngket[$a->nik] = [
                    'nama' => $a->getKaryawan($a->nik),
                    'rata_dosen' => $sumNilai / $countNilai,
                    'kode_mk' => [],

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
