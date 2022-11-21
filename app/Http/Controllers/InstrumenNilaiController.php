<?php

namespace App\Http\Controllers;

use App\Models\AgendaBelajar;
use App\Models\Clo;
use App\Models\DetailAgenda;
use App\Models\DetailInstrumenMonev;
use App\Models\DetailInstrumenNilai;
use App\Models\Fakultas;
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
use App\Models\Prodi;
use App\Models\RangkumanClo;
use App\Models\Rps;
use App\Models\Semester;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InstrumenNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $semester;

    public function __construct()
    {
        $this->semester = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
    }

    public function index()
    {
        $nik_kary = auth()->user()->nik;
        $role = auth()->user()->role;
        $smt = $this->semester;

        if ($role == 'dosen') {
            $jdwkul = JadwalKuliah::where('kary_nik', $nik_kary)->where('sts_kul', '1')->name()->paginate(6)->withQueryString();
            $instru = InstrumenNilai::whereNik($nik_kary)->get();
            return view('instrumen-nilai.index', compact('jdwkul', 'instru', 'smt'));
        }

        return view('instrumen-nilai.index', compact('smt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $nik_kary = auth()->user()->nik;
        $now = Carbon::now()->format('Y-m-d');
        $isRead = false;
        $idIns = $request->get('ins');
        $instru = InstrumenNilai::where('id', $request->get('ins'))->first();
        $smt = $this->semester;
        $weekEigth = [];
        $weekSixteen = [];

        if ($nik_kary != $instru->nik) {
            $isRead = true;
        }

        $jdw = JadwalKuliah::where('klkl_id', $instru->klkl_id)->where('kary_nik', $instru->nik)->where('sts_kul', '1')->first();

        $kul = MingguKuliah::where('jenis_smt', 'T')->where('smt', $instru->semester)->get();

        $week = '';
        foreach ($kul as $key => $value) {

            $weekStartDate = Carbon::parse($value->tgl_awal)->format('Y-m-d');
            $weekEndDate = Carbon::parse($value->tgl_akhir)->addDays(1)->format('Y-m-d');

            if ($now >= $weekStartDate && $now <= $weekEndDate) {
                $week = $value->minggu_ke;
                break;
            }

        }

        $wSeven = $kul->where('minggu_ke', '7')->first();
        $wNine = $kul->where('minggu_ke', '9')->first();
        $wFifth = $kul->where('minggu_ke', '15')->first();

        if($wSeven){
            $start = Carbon::parse($wSeven->tgl_awal)->addDays(7)->format('Y-m-d');
            $weekEigth['start'] = $start;
        }

        if($wNine){
            $end = Carbon::parse($wNine->tgl_awal)->subDays(1)->format('Y-m-d');
            $weekEigth['end'] = $end;
        }

        if($wFifth){

            $start = Carbon::parse($wFifth->tgl_awal)->addDays(7)->format('Y-m-d');
            $weekSixteen['start'] = $start;

        }


        if($now >= $weekEigth['start'] && $now <= $weekEigth['end']){
            $week = '8';
        } else if($now >= $weekSixteen['start']){
            $week = '16';
        }


        $rps = Rps::where('id', $instru->rps_id)->first();

        $getPekan = AgendaBelajar::where('rps_id', $rps->id)->where('pekan', $week)->first();

        if (!$getPekan) {
            Session::flash('message', 'Minggu Kuliah Belum Ditentukan');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('penilaian.clo.index');
        }

        // dd($week);
        $startFill = Carbon::parse($getPekan->tgl_nilai)->format('Y-m-d');
        $endFill = Carbon::parse($startFill)->addDays(14);
        // dd($endFill);
        $agd = AgendaBelajar::where('rps_id', $instru->rps_id)->pluck('id')->toArray();


        $dtlAgd = DetailAgenda::whereIn('agd_id', $agd)->with('penilaian','clo','detailInstrumenNilai')->orderby('clo_id', 'asc')->orderby('id', 'asc')->get();

        $krs = Krs::where('jkul_klkl_id', $instru->klkl_id)->where('jkul_kelas', $instru->kelas)->with('mahasiswa')->get();

        $dtlInstru = DetailInstrumenNilai::where('ins_nilai_id', $instru->id)->get();



        $mk = MataKuliah::where('id', $rps->kurlkl_id)->with('prodi')->first();

        $summary = RangkumanClo::where('ins_nilai_id', $idIns)->get();



        return view('instrumen-nilai.nilaimhs', compact('dtlAgd','krs', 'dtlInstru', 'idIns', 'instru', 'mk', 'jdw', 'summary', 'week', 'getPekan', 'now', 'startFill', 'endFill', 'isRead', 'smt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // untuk mendapatkan id kriteria monev
        $now = Carbon::now();

        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        $kriId = '';

        foreach ($kri as $key => $k) {
            if($key == 0){
                $kriId = $k->id;
                break;
            }
        }


        foreach ($request->get('dataNilai') as $n) {
            // untuk memasukkan nilai ke detail instrumen monev
            $insMonev = InstrumenMonev::where('ins_nilai_id', $request->get('idIns'))->first();
            if ($insMonev) {
                $dtlMonev = DetailInstrumenMonev::where('ins_monev_id', $insMonev->id)->where('dtl_agd_id', $n['dtl_id'])->first();
                if(!$dtlMonev){

                    $dtlAgd = DetailAgenda::where('id', $n['dtl_id'])->first();
                    $agd = AgendaBelajar::where('id', $dtlAgd->agd_id)->first();
                    $startDate = Carbon::parse($agd->tgl_nilai)->format('d-m-Y');
                    $twoWeek = Carbon::parse($agd->tgl_nilai)->addDays(14)->format('d-m-Y');
                    $fourWeek = Carbon::parse($agd->tgl_nilai)->addDays(28)->format('d-m-Y');
                    $sixWeek = Carbon::parse($agd->tgl_nilai)->addDays(42)->format('d-m-Y');
                    $eightWeek = Carbon::parse($agd->tgl_nilai)->addDays(56)->format('d-m-Y');
                    // dd($startDate);
                    if ($now->between($startDate, $twoWeek)) {
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 4,

                        ]);

                    }else if($now->between($twoWeek, $fourWeek)){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 3,

                        ]);
                    }else if($now->between($fourWeek, $sixWeek)){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 2,

                        ]);
                    }else if($now->between($sixWeek, $eightWeek)){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 1,

                        ]);
                    }else if($now->gt($eightWeek)){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 0,

                        ]);
                    }
                }

            }else{
                $insNilai = InstrumenNilai::where('id', $request->get('idIns'))->first();
                $plot = PlottingMonev::where('klkl_id', $insNilai->klkl_id)->where('nik_pengajar', $insNilai->nik)->where('semester', $insNilai->semester)->where('kelas', $insNilai->kelas)->first();

                if($plot){

                    $insMonev = InstrumenMonev::create([
                        'ins_nilai_id' => $request->get('idIns'),
                        'plot_monev_id' => $plot->id,
                    ]);
                }else{

                    Session::flash('message', 'Gagal memasukkan nilai, Instrumen ini belum di plotting, Silahkan hubungi bagian P3AI!');
                    Session::flash('alert-class', 'alert-danger');

                    return response()->json(['error' => 'Gagal memasukkan nilai, Instrumen ini belum di plotting, Silahkan hubungin bagian P3AI!']);

                }

                $dtlMonev = DetailInstrumenMonev::where('ins_monev_id', $insMonev->id)->where('dtl_agd_id', $n['dtl_id'])->first();

                if(!$dtlMonev){

                    $dtlAgd = DetailAgenda::where('id', $n['dtl_id'])->first();
                    $agd = AgendaBelajar::where('id', $dtlAgd->agd_id)->first();
                    $startDate = Carbon::parse($agd->tgl_nilai)->format('d-m-Y');
                    $twoWeek = Carbon::parse($agd->tgl_nilai)->addDays(14)->format('d-m-Y');
                    $fourWeek = Carbon::parse($agd->tgl_nilai)->addDays(28)->format('d-m-Y');
                    $sixWeek = Carbon::parse($agd->tgl_nilai)->addDays(42)->format('d-m-Y');
                    $eightWeek = Carbon::parse($agd->tgl_nilai)->addDays(56)->format('d-m-Y');
                    // dd($startDate);
                    if ($now >= $startDate && $now <= $twoWeek) {
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 4,

                        ]);

                    }else if($now >= $twoWeek && $now <= $fourWeek){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 3,

                        ]);
                    }else if($now >= $fourWeek && $now <= $sixWeek){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 2,

                        ]);
                    }else if($now >= $sixWeek && $now <= $eightWeek){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 1,

                        ]);
                    }else if($now->gt($eightWeek)){
                        DetailInstrumenMonev::create([
                            'ins_monev_id' => $insMonev->id,
                            'dtl_agd_id' => $n['dtl_id'],
                            'id_kri' => $kriId,
                            'nilai' => 0,

                        ]);
                    }
                }
            }

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
        $nik_kary = $request->nik;
        $kary = KaryawanDosen::where('nik',$nik_kary)->first();
        $smt = Semester::orderBy('smt_yad', 'desc')->first();

        $rps = Rps::where('kurlkl_id', $request->kode_mk)->where('semester', $smt->smt_yad)->get();

        if ($rps->count() > 1 ) {
            return response()->json([
                'error' => 'Terdapat Data RPS aktif yang sama, silahkan hubungi admin',
            ]);
        }else if($rps->count() == 0){
            return response()->json([
                'error' => 'RPS tidak ditemukan',
            ]);
        }else{
            $rps = $rps->first();
            if ($rps->is_done == '0') {
                return response()->json([
                    'error' => 'Data RPS belum selesai, silahkan hubungi penyusun RPS',
                ]);
            }
            $instru = InstrumenNilai::where('rps_id', $rps->id)->where('klkl_id', $request->kode_mk)
            ->where('nik', $nik_kary)
            ->first();

            if ($instru) {
                return response()->json([
                    'url' => route('penilaian.clo.create', ['ins' => $instru->id ]),
                ]);

            }else{
                $newInstru = InstrumenNilai::create([
                    'rps_id' => $rps->id,
                    'klkl_id' => $request->kode_mk,
                    'semester' => $smt->smt_yad,
                    'nik' => $nik_kary,
                    'kelas' => $request->kelas,
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

    public function detailInstrumen()
    {
        $user = auth()->user();
        $kary = KaryawanDosen::where('nik', request('nik'))->first();
        $smt = $this->semester;
        $instru = InstrumenNilai::all();

        if($user->role == 'kaprodi'){
            $prodi = Prodi::where('mngr_id', $user->nik)->first();
            $jdwkul = JadwalKuliah::where('kary_nik', $kary->nik)->where('prodi', $prodi->id)->where('sts_kul', '1')->name()->paginate(6)->withQueryString();
        }else if ($user->role == 'dekan'){
            $chkDekan = Fakultas::where('mngr_id', $user->nik)->first();
            $prodi = Prodi::where('id_fakultas', $chkDekan->id)->get();
            $jdwkul = JadwalKuliah::where('kary_nik', $kary->nik)->whereIn('prodi', $prodi->pluck('id')->toArray())->where('sts_kul', '1')->name()->paginate(6)->withQueryString();
        }else{
            $jdwkul = JadwalKuliah::where('kary_nik', $kary->nik)->where('sts_kul', '1')->name()->paginate(6)->withQueryString();
        }

        return view('instrumen-nilai.detail', compact('jdwkul', 'kary', 'instru', 'smt'));

    }

    public function rangkumanCapaianClo()
    {
        $user = auth()->user();

        if ($user->role == 'kaprodi') {

            $prodi = Prodi::where('mngr_id', $user->nik)->first();
            $jdw = JadwalKuliah::where('prodi', $prodi->id)->where('sts_kul', '1')->get();

            $rang = $this->getCapaiClo($jdw);

            return response()->json($rang);

        }else if($user->role == 'dekan'){
            $chkDekan = Fakultas::where('mngr_id', $user->nik)->first();
            $prodi = Prodi::where('id_fakultas', $chkDekan->id)->get();
            $jdw = JadwalKuliah::whereIn('prodi', $prodi->pluck('id')->toArray())->where('sts_kul', '1')->get();

            $rang = $this->getCapaiClo($jdw);

            return response()->json($rang);
        }else{
            $jdw = JadwalKuliah::where('sts_kul', '1')->get();

            $rang = $this->getCapaiClo($jdw);

            return response()->json($rang);
        }
    }

    public function getCapaiClo($jdw)
    {
        $countJdw = $jdw->count();
        $jmlInsLulus = 0;
        $mkLulus = [];
        foreach ($jdw as $j) {

            $cekIns = InstrumenNilai::where('klkl_id', $j->klkl_id)->where('semester', $this->semester)->whereNik($j->kary_nik)->whereKelas($j->kelas)->first();

            if ($cekIns) {
                $krs = Krs::where('jkul_kelas', $j->kelas)->where('jkul_klkl_id', $j->klkl_id)->get();

                $countKrs = $krs->count();

                $dtlIns = DetailInstrumenNilai::where('ins_nilai_id', $cekIns->id)->orderBy('mhs_nim', 'asc')->get();

                $arrDtlIns = $dtlIns->groupBy('mhs_nim');

                $clo = Clo::where('rps_id', $cekIns->rps_id)->orderBy('id', 'asc')->get();
                $countClo = $clo->count();
                $totalMkLulus = $countKrs * $countClo;
                $cnCloMhs = 0;

                foreach($clo as $c){

                    $dtlAgd = DetailAgenda::where('clo_id', $c->id)->where('penilaian_id', '<>' , null)->get();
                    $sumBobot = $dtlAgd->sum('bobot');

                    foreach($arrDtlIns as $key => $di){
                        $nilaiClo = 0;
                        foreach ($di as $dtl) {
                            if($dtl->detailAgenda->clo_id == $c->id ){
                                $nilai = $dtl->nilai;
                                $bobot = $dtl->detailAgenda->bobot / 100;
                                $nilaiClo =+ $nilai * $bobot;
                            }
                        }

                        $nilaiKonv = $sumBobot == 0 ? 0 : $nilaiClo / $sumBobot;
                        $nilaiMinClo = $c->nilai_min;

                        if($nilaiKonv >= $nilaiMinClo){
                            $cnCloMhs++;
                        }
                    }

                }

                if($cnCloMhs == $totalMkLulus){
                    $jmlInsLulus++;
                    $mkLulus[] = $j;

                }

            }
        }
        dd($jmlInsLulus);
        $jmlInsTdkLulus = $countJdw - $jmlInsLulus;

        return ['jmlInsLulus' => $jmlInsLulus, 'jmlInsTdkLulus' => $jmlInsTdkLulus, 'mkLulus' => $mkLulus];
    }

    public function rangkumCapaiCloList()
    {
        $user = auth()->user();

        if ($user->role == 'kaprodi') {

            $prodi = Prodi::where('mngr_id', $user->nik)->first();
            $jdw = JadwalKuliah::where('prodi', $prodi->id)->where('sts_kul', '1')->get();

            $mkLulus = collect($this->getCapaiClo($jdw)['mkLulus']);

            $mkTdkLulus = JadwalKuliah::where('prodi', $prodi->id)->where('sts_kul', '1')->whereNotIn('klkl_id', $mkLulus->pluck('klkl_id')->toArray())->get();

            $smt = $this->semester;

            return view('instrumen-nilai.capai-clo-list', compact('mkLulus', 'mkTdkLulus', 'smt'));

        }else if($user->role == 'dekan'){
            $chkDekan = Fakultas::where('mngr_id', $user->nik)->first();
            $prodi = Prodi::where('id_fakultas', $chkDekan->id)->get();
            $jdw = JadwalKuliah::whereIn('prodi', $prodi->pluck('id')->toArray())->where('sts_kul', '1')->get();

            $mkLulus = collect($this->getCapaiClo($jdw)['mkLulus']);

            $mkTdkLulus = JadwalKuliah::whereIn('prodi', $prodi->pluck('id')->toArray())->where('sts_kul', '1')->whereNotIn('klkl_id', $mkLulus->pluck('klkl_id')->toArray())->get();

            $smt = $this->semester;

            return view('instrumen-nilai.capai-clo-list', compact('mkLulus', 'mkTdkLulus', 'smt'));
        }else{
            $jdw = JadwalKuliah::where('sts_kul', '1')->get();

            $mkLulus = collect($this->getCapaiClo($jdw)['mkLulus']);

            $mkTdkLulus = JadwalKuliah::where('sts_kul', '1')
            ->whereNotIn('klkl_id',$mkLulus->pluck('klkl_id')->toArray())->get();

            $smt = $this->semester;

            return view('instrumen-nilai.capai-clo-list', compact('mkLulus', 'mkTdkLulus', 'smt'));
        }
    }
}
