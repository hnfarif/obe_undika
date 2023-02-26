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
    private $fakultas;
    private $prodi;
    private $angket;

    public function __construct()
    {
        $this->semester = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
        $this->fakultas = Fakultas::where('sts_aktif', 'Y')->with('prodis')->get();
        $this->prodi = Prodi::whereIn('id_fakultas', $this->fakultas->pluck('id')->toArray())->where('sts_aktif', 'Y')->get();
        $this->angket = AngketTrans::select('nik')->with('karyawan')->distinct('nik')->fakultas()->prodi()->dosen()->get();
    }

    public function index()
    {
        $fak = $this->fakultas;
        $kary = KaryawanDosen::where('kary_type', 'like', '%D%')->get();
        $prodi = $this->prodi;

        $angket = $this->manipulateDataAngket('angket', $this->angket);

        $rata = $this->manipulateDataAngket('rata', $fak);

        $labelProdi = [];
        $rataProdi = [];

        foreach($rata as $r){
            foreach($r->prodis as $p){
                $labelProdi[] = $p->nama;
                $rataProdi[] = $p->rata;
            }
        }

        $smt = $this->semester;

        return view('laporan.angket.index', compact('angket', 'fak', 'prodi', 'kary','smt', 'rata', 'labelProdi', 'rataProdi'));
    }

    public function manipulateDataAngket($sts, $data){
        $result = '';

        if($sts == 'angket'){
            $ang = $data;
            $angket = tap($ang)->transform(function($data){
                $data->detail = AngketTrans::selectRaw('kode_mk, kelas, avg(nilai) as rata_mk')->join('kurlkl_mf','angket_tf.kode_mk','kurlkl_mf.id')->where('nik',$data->nik)->where('smt','221')->groupBy('kode_mk','kelas')->get();
                $data->rata_dosen = AngketTrans::where('nik',$data->nik)->where('smt','221')->avg('nilai');
                return $data;
            });
            $result = $angket;
        }

        if($sts == 'rata'){
            $fak = $data;
            $rata_fak = tap($fak)->transform(function($data){
                $data->rata = AngketTrans::join('fak_mf', 'angket_tf.prodi', 'fak_mf.id')->where('smt','221')->where('id_fakultas', $data->id)->avg('nilai');
                tap($data->prodis)->transform(function($data){
                    $data->rata = AngketTrans::where('prodi',$data->id)->where('smt','221')->avg('nilai');
                    return $data;
                });
                return $data;
            });
            $result = $rata_fak;
        }

        return $result;
    }

    public function exportPdf()
    {
        $fak = $this->fakultas;

        $angket = $this->manipulateDataAngket('angket', $this->angket);
        $rata = $this->manipulateDataAngket('rata', $fak);

        $pdf = PDF::loadView('laporan.angket.export-pdf', ['fak' => $fak,
        'angket' => $angket,
        'rata' => $rata,
        ]);

        ini_set('max_execution_time', 300);
        ini_set("memory_limit","512M");

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
