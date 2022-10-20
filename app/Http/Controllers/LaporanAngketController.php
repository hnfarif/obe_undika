<?php

namespace App\Http\Controllers;

use App\Models\AngketTrans;
use App\Models\Fakultas;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\MataKuliah;
use App\Models\PlottingMonev;
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
        $plot = PlottingMonev::where('semester', $smt->smt_yad)->get();
        $angket = AngketTrans::where('smt', $smt->smt_yad)->get();

        $data = [];

        foreach ($plot as $p) {
            $data[$p->kode_mk]['nik'] = $p->nik_pengajar;
            $data[$p->kode_mk]['nama'] = $p->karyawan->nama;
            $data[$p->kode_mk]['kode_mk'] = $p->klkl_id;
            $data[$p->kode_mk]['nama_mk'] = $p->matakuliah->nama;
            $data[$p->kode_mk]['kelas'] = $p->kelas;
            $data[$p->kode_mk]['rata_mk'] = $angket->where('nik', $p->nik_pengajar)->where('kode_mk', $p->klkl_id)->where('kelas', $p->kelas)->avg('nilai');
        }





        return $data;
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
