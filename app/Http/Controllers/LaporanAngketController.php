<?php

namespace App\Http\Controllers;

use App\Models\AngketTrans;
use App\Models\Fakultas;
use App\Models\KaryawanDosen;
use App\Models\MingguKuliah;
use App\Models\PlottingMonev;
use App\Models\Prodi;
use App\Models\Semester;
use PDF;


class LaporanAngketController extends Controller
{
    private $semester;

    public function __construct()
    {
        $this->semester = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
    }

    public function index()
    {
        $fak = Fakultas::where('sts_aktif', 'Y')->get();
        $arrFak = $fak->pluck('id')->toArray();
        $prodi = Prodi::whereIn('id_fakultas', $arrFak)->where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::where('kary_type', 'like', '%D%')->get();

        $angket = $this->manipulateDataAngket($prodi, $fak)['data'];

        $rataProdi = $this->manipulateDataAngket($prodi, $fak)['rataProdi'];

        $rataFak = $this->manipulateDataAngket($prodi, $fak)['rataFakultas'];

        $smt = $this->semester;

        return view('laporan.angket.index', compact('angket', 'fak', 'prodi', 'kary', 'rataProdi', 'rataFak', 'smt'));
    }

    public function manipulateDataAngket($prodi, $fak){

        $smt = $this->semester;
        $plot = PlottingMonev::where('semester', $smt)->prodi()->get();
        $angket = AngketTrans::where('smt', $smt)->whereIn('prodi', $plot->pluck('prodi')->toArray())->get()->groupBy('nik');
        $ratamk = $angket;

        $data = [];
        $rataProdi = [];
        $rataFakultas = [];

        foreach ($plot as $p) {

            $rata_mk = $ratamk->where('nik', $p->nik_pengajar)->where('kode_mk', $p->klkl_id)->where('prodi', $p->prodi)->avg('nilai');

            $data[$p->nik_pengajar]['nama'] = $p->karyawan->nama;
            $data[$p->nik_pengajar]['matakuliah'][$p->klkl_id][$p->kelas]['nama'] = $p->matakuliah->nama;
            $data[$p->nik_pengajar]['matakuliah'][$p->klkl_id][$p->kelas]['prodi'] = $p->prodi;
            $data[$p->nik_pengajar]['matakuliah'][$p->klkl_id][$p->kelas]['rata_mk'] = number_format($rata_mk, 2);

            $count = count($data[$p->nik_pengajar]['matakuliah']);
            $sum = 0;

            foreach ($data[$p->nik_pengajar]['matakuliah'] as $mk) {
                foreach ($mk as $kls) {
                    $sum += $kls['rata_mk'];
                }
            }

            $avgDosen = $count == 0 ? 0 : number_format($sum / $count, 2);
            $data[$p->nik_pengajar]['rata_dosen'] = $avgDosen;

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

        $fak = Fakultas::where('sts_aktif', 'Y')->get();
        $arrFak = $fak->pluck('id')->toArray();
        $prodi = Prodi::whereIn('id_fakultas', $arrFak)->where('sts_aktif', 'Y')->get();

        $angket = $this->manipulateDataAngket($prodi, $fak)['data'];

        $rataProdi = $this->manipulateDataAngket($prodi, $fak)['rataProdi'];

        $rataFak = $this->manipulateDataAngket($prodi, $fak)['rataFakultas'];

        $pdf = PDF::loadView('laporan.angket.export-pdf', ['fak' => $fak,
        'filterAngket' => $angket,
        'prodi' => $filProdi,
        'rataProdi' => $rataProdi,
        'rataFak' => $rataFak,
        ]);

        return $pdf->stream('laporan_angket_'.date('Y-m-d_H-i-s').'.pdf');
    }

    public function cekData()
    {
       $clo = AngketTrans::where('smt', '221')->get()->groupBy('nik');

        return [
            'clo' => $clo,
            'countAngket' => $clo->count(),

        ];
    }
}
