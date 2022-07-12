<?php

namespace App\Http\Controllers;

use App\Models\AgendaBelajar;
use App\Models\Clo;
use App\Models\DetailAgenda;
use App\Models\DetailInstrumenNilai;
use App\Models\InstrumenNilai;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\Krs;
use App\Models\Kuliah;
use App\Models\MataKuliah;
use App\Models\Penilaian;
use App\Models\RangkumanClo;
use App\Models\Rps;
use App\Models\Semester;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InstrumenNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nik_kary = auth()->user()->nik;
        $kary = KaryawanDosen::where('nik',$nik_kary)->first();
        $smt = Semester::where('fak_id', $kary->fakul_id)->first();
        $rps = Rps::where('kurlkl_id', 'LIKE', "{$kary->fakul_id}%")->where('is_active', '1')
        ->where('semester', $smt->smt_aktif)
        ->pluck('kurlkl_id')->toArray();

        $arrKlkl = [];
        foreach ($rps as $i) {
            $arrKlkl[] = substr($i, 5);
        }

        $jdwkul = JadwalKuliah::where('kary_nik', $nik_kary)->where('sts_kul', '1')->whereIn('klkl_id', $arrKlkl)->get();

        $instru = InstrumenNilai::all();

        return view('instrumen-nilai.index', compact('jdwkul', 'instru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $now = Carbon::now();
        // dd($now->endOfWeek()->format('d-m-Y'));
        $idIns = $request->get('ins');
        $instru = InstrumenNilai::where('id', $request->get('ins'))->first();

        $jdw = JadwalKuliah::where('klkl_id', $instru->klkl_id)->where('kary_nik', $instru->nik)->where('sts_kul', '1')->first();

        $kul = Kuliah::where('jkul_kelas', $jdw->kelas)->where('jkul_klkl_id', $jdw->prodi.$jdw->klkl_id)->where('jkul_kary_nik', $jdw->kary_nik)->get();

        $week = 0;
        foreach ($kul as $k) {
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d');
            $tglKul = Carbon::parse($k->tanggal)->format('Y-m-d');
            $week++;
            if (($weekStartDate <= $tglKul) && ($tglKul <= $weekEndDate) ) {

                break;
            }
        }

        $rps = Rps::where('id', $instru->rps_id)->first();

        $getPekan = AgendaBelajar::where('rps_id', $rps->id)->where('pekan', $week)->first();

        $agd = AgendaBelajar::where('rps_id', $instru->rps_id)->pluck('id')->toArray();


        $dtlAgd = DetailAgenda::whereIn('agd_id', $agd)->with('penilaian','clo','detailInstrumenNilai')->orderby('clo_id', 'asc')->orderby('id', 'asc')->get();

        $krs = Krs::where('jkul_klkl_id', $instru->klkl_id)->where('jkul_kelas', $jdw->kelas)->with('mahasiswa')->get();

        $dtlInstru = DetailInstrumenNilai::where('ins_nilai_id', $instru->id)->get();



        $mk = MataKuliah::where('id', $rps->kurlkl_id)->with('prodi')->first();

        $summary = RangkumanClo::where('ins_nilai_id', $idIns)->get();



        return view('instrumen-nilai.nilaimhs', compact('dtlAgd','krs', 'dtlInstru', 'idIns', 'instru', 'mk', 'jdw', 'summary', 'week', 'getPekan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->get('dataNilai') as $n) {

            $findDtlIns = DetailInstrumenNilai::where('mhs_nim', $n['nim'])->where('dtl_agd_id', $n['dtl_id'])
            ->where('ins_nilai_id', $request->get('idIns'))->first();

            if ($findDtlIns) {

                $dtlIns = DetailInstrumenNilai::where('id', $findDtlIns->id)->update([
                    'nilai' => $n['nilai'],
                ]);

            } else {
                $dtlIns = new DetailInstrumenNilai();
                $dtlIns->ins_nilai_id = $request->get('idIns');
                $dtlIns->dtl_agd_id = $n['dtl_id'];
                $dtlIns->mhs_nim = $n['nim'];
                $dtlIns->nilai = $n['nilai'];
                $dtlIns->save();

            }
        }
        return response()->json(['success' => 'Data Berhasil Disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cekRps(Request $request)
    {
        $nik_kary = auth()->user()->nik;
        $kary = KaryawanDosen::where('nik',$nik_kary)->first();
        $smt = Semester::where('fak_id', $kary->fakul_id)->first();

        $rps = Rps::where('kurlkl_id', $request->kode_mk)->where('is_active', '1')->where('semester', $smt->smt_aktif)->get();

        if ($rps->count() > 1 ) {
            return response()->json([
                'error' => 'Terdapat Data RPS aktif yang sama, silahkan hubungi admin',
            ]);
        }else if($rps->count() == 0){
            return response()->json([
                'error' => 'Data RPS tidak ditemukan',
            ]);
        }else{
            $rps = $rps->first();
            $instru = InstrumenNilai::where('rps_id', $rps->id)->where('klkl_id', substr($request->kode_mk, 5))
            ->where('nik', $nik_kary)
            ->first();

            if ($instru) {
                return response()->json([
                    'url' => route('penilaian.clo.create', ['ins' => $instru->id ]),
                ]);

            }else{
                $newInstru = InstrumenNilai::create([
                    'rps_id' => $rps->id,
                    'klkl_id' => substr($request->kode_mk, 5),
                    'semester' => $smt->smt_aktif,
                    'nik' => $nik_kary,
                ]);

                return response()->json([
                    'url' => route('penilaian.clo.create', ['ins' => $newInstru->id ]),
                ]);
            }

        }
    }

    public function uptNilaiMin(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nilai_min' => 'required|numeric',
        ]);

        $instru = InstrumenNilai::where('id', $request->get('idIns'))->first();
        $instru->nilai_min_mk = $request->get('nilai_min_mk');
        $instru->save();

        return redirect()->back();
    }

    public function storeSummary(Request $request)
    {
        foreach ($request->get('dataSum') as $sum) {

            $findSum = RangkumanClo::where('clo_id', $sum['idClo'])->where('ins_nilai_id', $sum['idIns'])->first();

            if ($findSum) {
                if ($sum['sts'] == 'improvClo') {
                    RangkumanClo::where('clo_id', $sum['idClo'])->where('ins_nilai_id', $sum['idIns'])->update([
                        'perbaikan' => $sum['desc'],
                    ]);
                }else{
                    RangkumanClo::where('clo_id', $sum['idClo'])->where('ins_nilai_id', $sum['idIns'])->update([
                        'sbb_gagal' => $sum['desc'],
                    ]);
                }
            }else{
                if ($sum['sts'] == 'improvClo') {
                    RangkumanClo::create([
                        'clo_id' => $sum['idClo'],
                        'ins_nilai_id' => $sum['idIns'],
                        'perbaikan' => $sum['desc'],

                    ]);
                }else{
                    RangkumanClo::create([
                        'clo_id' => $sum['idClo'],
                        'ins_nilai_id' => $sum['idIns'],
                        'sbb_gagal' => $sum['desc'],

                    ]);
                }

            }

        }
        return response()->json(['success' => 'Data Berhasil Disimpan']);
    }

}
