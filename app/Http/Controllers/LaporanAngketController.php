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

        $ang = $this->manipulateDataAngket();

        dd($ang);

        return view('laporan.angket.index', compact('angket', 'fak', 'prodi', 'kary' ));
    }

    public function manipulateDataAngket(){

        $smt = Semester::orderBy('smt_yad', 'desc')->first();
        $plot = PlottingMonev::where('semester', $smt->smt_yad)->get();
        $angket = AngketTrans::where('smt', $smt->smt_yad)->get();
        $ratamk = $angket;

        $data = [];

        foreach ($plot as $p) {
            $rata_dosen =  $angket->where('nik', $p->nik_pengajar)->avg('nilai');
            $rata_mk = $ratamk->where('nik', $p->nik_pengajar)->where('kode_mk', $p->klkl_id)->where('kelas', $p->kelas)->avg('nilai');

            $data[$p->nik_pengajar]['nama'] = $p->karyawan->nama;
            $data[$p->nik_pengajar]['rata_dosen'] = $rata_dosen;
            $data[$p->nik_pengajar]['matakuliah'][$p->klkl_id][$p->kelas]['nama'] = $p->matakuliah->nama;
            $data[$p->nik_pengajar]['matakuliah'][$p->klkl_id][$p->kelas]['rata_mk'] = $rata_mk;
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
