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

        $angket = $this->manipulateDataAngket($prodi, $fak);

        dd($angket);

        return view('laporan.angket.index', compact('angket', 'fak', 'prodi', 'kary' ));
    }

    public function manipulateDataAngket($prodi, $fak){

        $smt = Semester::orderBy('smt_yad', 'desc')->first();
        $plot = PlottingMonev::where('semester', $smt->smt_yad)->get();
        $angket = AngketTrans::where('smt', $smt->smt_yad)->get();
        $ratamk = $angket;

        $data = [];
        $rataProdi = [];
        $rataFakultas = [];

        foreach ($plot as $p) {
            $rata_dosen =  $angket->where('nik', $p->nik_pengajar)->avg('nilai');
            $rata_mk = $ratamk->where('nik', $p->nik_pengajar)->where('kode_mk', $p->klkl_id)->where('prodi', $p->prodi)->avg('nilai');

            $data[$p->nik_pengajar]['nama'] = $p->karyawan->nama;
            $data[$p->nik_pengajar]['rata_dosen'] = number_format($rata_dosen, 2);
            $data[$p->nik_pengajar]['matakuliah'][$p->klkl_id]['prodi'] = $p->programstudi->nama;
            $data[$p->nik_pengajar]['matakuliah'][$p->klkl_id][$p->kelas]['nama'] = $p->matakuliah->nama;
            $data[$p->nik_pengajar]['matakuliah'][$p->klkl_id][$p->kelas]['rata_mk'] = number_format($rata_mk, 2);
        }

        foreach ($prodi as $value) {
            $rataProdi[$value->id]['nama'] = $value->nama;
            $rataProdi[$value->id]['rata_prodi'] = number_format($angket->where('prodi', $value->id)->avg('nilai'), 2);
        }

        foreach ($fak as $value) {
            $rataFakultas[$value->id]['nama'] = $value->nama;
            $rataFakultas[$value->id]['rata_fakultas'] = number_format($angket->whereIn('prodi', $value->prodis->pluck('id')->toArray())->avg('nilai'), 2);
        }

        return [
            'data' => $data,
            'rataProdi' => $rataProdi,
            'rataFakultas' => $rataFakultas,
        ];
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
