<?php

namespace App\Http\Controllers;

use App\Models\AgendaBelajar;
use App\Models\Clo;
use App\Models\DetailAgenda;
use App\Models\DetailInstrumenMonev;
use App\Models\DetailInstrumenNilai;
use App\Models\InstrumenMonev;
use App\Models\InstrumenNilai;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\KriteriaMonev;
use App\Models\Krs;
use App\Models\Kuliah;
use App\Models\MataKuliah;
use App\Models\MingguKuliah;
use App\Models\Penilaian;
use App\Models\PlottingMonev;
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

        $kul = MingguKuliah::where('smt', $instru->semester)->get();

        $week = '';
        foreach ($kul as $k) {
            $weekStartDate = Carbon::parse($k->tgl_awal)->format('Y-m-d');
            $weekEndDate = Carbon::parse($k->tgl_akhir)->format('Y-m-d');

            if ($now >= $weekStartDate && $now <= $weekEndDate) {
                $week = $k->minggu_ke;
                break;
            }

        }
        // dd($week);
        $rps = Rps::where('id', $instru->rps_id)->first();

        $getPekan = AgendaBelajar::where('rps_id', $rps->id)->where('pekan', $week)->first();

        // dd($getPekan->tgl_nilai);
        $startFill = Carbon::parse($getPekan->tgl_nilai)->format('Y-m-d');
        $endFill = Carbon::parse($startFill)->addDays(14)->format('d-m-Y');
        // dd($endFill);
        $agd = AgendaBelajar::where('rps_id', $instru->rps_id)->pluck('id')->toArray();


        $dtlAgd = DetailAgenda::whereIn('agd_id', $agd)->with('penilaian','clo','detailInstrumenNilai')->orderby('clo_id', 'asc')->orderby('id', 'asc')->get();

        $krs = Krs::where('jkul_klkl_id', $instru->klkl_id)->where('jkul_kelas', $jdw->kelas)->with('mahasiswa')->get();

        $dtlInstru = DetailInstrumenNilai::where('ins_nilai_id', $instru->id)->get();



        $mk = MataKuliah::where('id', $rps->kurlkl_id)->with('prodi')->first();

        $summary = RangkumanClo::where('ins_nilai_id', $idIns)->get();



        return view('instrumen-nilai.nilaimhs', compact('dtlAgd','krs', 'dtlInstru', 'idIns', 'instru', 'mk', 'jdw', 'summary', 'week', 'getPekan', 'now', 'startFill', 'endFill'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // untuk mendapatkan id kriteria monev
        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        $kriId = '';

        foreach ($kri as $key => $k) {
            if($key == 0){
                $kriId = $k->id;
                break;
            }
        }


        foreach ($request->get('dataNilai') as $n) {

            // untuk menyimpan data ke dalam tabel detail instrumen nilai
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

            // untuk memasukkan nilai ke detail instrumen monev
            $insMonev = InstrumenMonev::where('ins_nilai_id', $request->get('idIns'))->first();
            if ($insMonev) {
                $dtlMonev = DetailInstrumenMonev::where('ins_monev_id', $insMonev->id)->where('dtl_agd_id', $n['dtl_id'])->first();
                if(!$dtlMonev){
                    $now = Carbon::now();
                    $dtlAgd = DetailAgenda::where('id', $n['dtl_id'])->first();
                    $agd = AgendaBelajar::where('id', $dtlAgd->agd_id)->first();
                    $startDate = Carbon::parse($agd->tgl_awal)->format('d-m-Y');
                    $twoWeek = Carbon::parse($agd->tgl_nilai)->addDays(14)->format('d-m-Y');
                    $fourWeek = Carbon::parse($agd->tgl_nilai)->addDays(28)->format('d-m-Y');
                    $sixWeek = Carbon::parse($agd->tgl_nilai)->addDays(42)->format('d-m-Y');
                    $eightWeek = Carbon::parse($agd->tgl_nilai)->addDays(56)->format('d-m-Y');
                    if ($now->format('d-m-Y') >= $startDate && $now->format('d-m-Y') <= $twoWeek) {
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 4,

                        ]);

                    }else if($now->format('d-m-Y') >= $twoWeek && $now->format('d-m-Y') <= $fourWeek){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 3,

                        ]);
                    }else if($now->format('d-m-Y') >= $fourWeek && $now->format('d-m-Y') <= $sixWeek){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 2,

                        ]);
                    }else if($now->format('d-m-Y') >= $sixWeek && $now->format('d-m-Y') <= $eightWeek){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 1,

                        ]);
                    }else if($now->format('d-m-Y') >= $eightWeek){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 0,

                        ]);
                    }else{
                        return response()->json(['success' => 'Data Berhasil Disimpan']);
                    }
                }

            }else{
                $insNilai = InstrumenNilai::where('id', $request->get('idIns'))->first();
                $plot = PlottingMonev::where('klkl_id', $insNilai->klkl_id)->where('nik_pengajar', $insNilai->nik)->where('semester', $insNilai->semester)->first();

                $insMonev = InstrumenMonev::create([
                    'ins_nilai_id' => $request->get('idIns'),
                    'plot_monev_id' => $plot->id,
                ]);

                $dtlMonev = DetailInstrumenMonev::where('ins_monev_id', $insMonev->id)->where('dtl_agd_id', $n['dtl_id'])->first();

                if(!$dtlMonev){
                    $now = Carbon::now();
                    $dtlAgd = DetailAgenda::where('id', $n['dtl_id'])->first();
                    $agd = AgendaBelajar::where('id', $dtlAgd->agd_id)->first();
                    $twoWeek = Carbon::parse($agd->tgl_nilai)->addDays(14)->format('d-m-Y');
                    $fourWeek = Carbon::parse($agd->tgl_nilai)->addDays(28)->format('d-m-Y');
                    $sixWeek = Carbon::parse($agd->tgl_nilai)->addDays(42)->format('d-m-Y');
                    $eightWeek = Carbon::parse($agd->tgl_nilai)->addDays(56)->format('d-m-Y');
                    if ($twoWeek >= $now->format('Y-m-d')) {
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 4,

                        ]);

                    }else if($fourWeek >= $now->format('Y-m-d')){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 3,

                        ]);
                    }else if($sixWeek >= $now->format('Y-m-d')){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 2,

                        ]);
                    }else if($eightWeek >= $now->format('Y-m-d')){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 1,

                        ]);
                    }else if($eightWeek <= $now->format('Y-m-d')){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 0,

                        ]);
                    }else{
                        return response()->json(['success' => 'Data Berhasil Disimpan']);
                    }
                }
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