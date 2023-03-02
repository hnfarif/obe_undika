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
        $this->angket = AngketTrans::where('smt', '221')->with('karyawan', 'prodii')->fakultas()->prodi()->dosen()->get()->groupBy('nik');
    }

    public function index()
    {
        $fak = $this->fakultas;
        $kary = KaryawanDosen::where('kary_type', 'like', '%D%')->get();
        $prodi = $this->prodi;
        $angket = $this->angket;

        $rata = $this->manipulateDataAngket($angket, $fak);

        $smt = $this->semester;

        return view('laporan.angket.index', compact('angket', 'fak', 'prodi', 'kary','smt', 'rata'));
    }

    public function manipulateDataAngket($angket, $fak){
        if($angket){
            $rata_fak = tap($fak)->transform(function($data) use ($angket){
                $jmlPro = 0;
                foreach ($angket as $a) {
                    foreach ($a as $p) {
                        if ($data->id == $p->prodii->id_fakultas) {
                            $data->rata += $p->nilai;
                            $jmlPro += 1;
                        }
                    }
                }
                $data->rata = $jmlPro == 0 ? 0 : number_format($data->rata / $jmlPro, 2);
                tap($data->prodis)->transform(function($prodi) use ($angket){
                    $jmlMk = 0;
                    foreach ($angket as $a) {
                        foreach ($a as $p) {
                            if ($prodi->id == $p->prodi) {
                                $prodi->rata += $p->nilai;
                                $jmlMk += 1;
                            }
                        }
                    }
                    $prodi->rata = $jmlMk == 0 ? 0 : number_format($prodi->rata / $jmlMk, 2);
                    return $prodi;
                });
                return $data;
            });
        }else{
            $rata_fak = tap($fak)->transform(function($data){
                $data->rata = 0;
                tap($data->prodis)->transform(function($prodi){
                    $prodi->rata = 0;
                    return $prodi;
                });
                return $data;
            });
        }

        return $rata_fak;
    }

    public function exportPdf()
    {
        $fak = $this->fakultas;

        $angket = $this->angket;
        $rata = $this->manipulateDataAngket($angket, $fak);

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
