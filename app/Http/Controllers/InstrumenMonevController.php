<?php

namespace App\Http\Controllers;

use App\Models\AgendaBelajar;
use App\Models\Bap;
use App\Models\Clo;
use App\Models\DetailAgenda;
use App\Models\DetailBap;
use App\Models\DetailInstrumenMonev;
use App\Models\Fakultas;
use App\Models\InstrumenMonev;
use App\Models\InstrumenNilai;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\KriteriaMonev;
use App\Models\Krs;
use App\Models\Llo;
use App\Models\MingguKuliah;
use App\Models\Penilaian;
use App\Models\PlottingMonev;
use App\Models\Prodi;
use App\Models\Rps;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InstrumenMonevController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->get('id'));

        $plot = PlottingMonev::where('id', $request->get('id'))->first();
        $cekInsNilai = InstrumenNilai::where('klkl_id', $plot->klkl_id)->where('nik', $plot->nik_pengajar)->where('semester', $plot->semester)->first();
        if ($cekInsNilai) {

            // buat instrumen monev baru
            $insNilai = $cekInsNilai->id;
            $cekInsMon = InstrumenMonev::where('plot_monev_id', $request->get('id'))->first();

            if(!$cekInsMon){
                $insMon = new InstrumenMonev;
                $insMon->plot_monev_id = $request->get('id');
                $insMon->ins_nilai_id = $cekInsNilai->id;
                $insMon->save();
            }

            // data untuk penilaian CLO
            $now = Carbon::now()->format('Y-m-d');
            $kri = KriteriaMonev::all();
            $agd = AgendaBelajar::where('rps_id', $cekInsNilai->rps_id)->get();
            $dtlAgd = DetailAgenda::whereIn('agd_id', $agd->pluck('id')->toArray())->with('penilaian','clo','detailInstrumenNilai','agendaBelajar')->orderby('clo_id', 'asc')->orderby('id', 'asc')->get();
            $dtlInsMon = DetailInstrumenMonev::where('ins_monev_id', $cekInsMon->id)->get();

            $kul = MingguKuliah::where('smt', $cekInsNilai->semester)->get();

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
            $rps = Rps::where('id', $cekInsNilai->rps_id)->first();

            $getPekan = AgendaBelajar::where('rps_id', $rps->id)->where('pekan', $week)->first();

            // dd($getPekan->tgl_nilai);
            $startFill = Carbon::parse($getPekan->tgl_nilai);
            $endFill = Carbon::parse($startFill)->addDays(14);

            //data RPS
            $agenda = AgendaBelajar::where('rps_id', $cekInsNilai->rps_id)->with('detailAgendas')
            ->orderBy('pekan', 'asc')->get();

            $clo = Clo::where('rps_id', $rps->id)->orderBy('id')->get();
            $penilaian = Penilaian::where('rps_id', $rps->id)->get();
            $llo = Llo::where('rps_id', $rps->id)->orderBy('id','asc')->get();

            // data BAP
            $jdw = JadwalKuliah::where('klkl_id', $cekInsNilai->klkl_id)->where('kary_nik', $cekInsNilai->nik)->where('sts_kul', '1')->first();
            $smt = Semester::where('fak_id', $jdw->prodi)->first();
            $krs = Krs::where('jkul_klkl_id', $cekInsNilai->klkl_id)->where('jkul_kelas', $jdw->kelas)->where('kary_nik', $jdw->kary_nik)->with('mahasiswa')->get();
            $jmlMhs = $krs->count();
            $jmlPre = $krs->where('sts_pre', '1')->count();
            $dtlBap = DetailBap::where('nik', $cekInsNilai->nik)->get();
            $plDtlBap = $dtlBap->pluck('kode_bap')->toArray();
            $bap = Bap::whereIn('kode_bap', $plDtlBap)->where('kode_mk', $jdw->klkl_id)->where('prodi', $jdw->prodi)->get();


            // mencari pertemuan sesuai tanggal
            $kul = MingguKuliah::where('smt', $plot->semester)->get();

            $week = '';
            foreach ($kul as $k) {
                $weekStartDate = Carbon::parse($k->tgl_awal)->format('Y-m-d');
                $weekEndDate = Carbon::parse($k->tgl_akhir)->format('Y-m-d');

                if ($now >= $weekStartDate && $now <= $weekEndDate) {
                    $week = $k->minggu_ke;
                    break;
                }

            }


            return view('instrumen-monev.index', compact('agd','kri','dtlAgd', 'dtlInsMon', 'insNilai', 'startFill', 'now', 'getPekan', 'krs', 'cekInsNilai', 'jmlMhs', 'jmlPre', 'cekInsMon', 'dtlBap', 'bap', 'rps', 'agenda', 'clo', 'penilaian', 'llo', 'plot', 'week'));
        }else{
            Session::flash('message', 'Buat instrumen monev gagal, karena dosen belum membuat instrumen penilaian CLO!');
            Session::flash('alert-class', 'alert-danger');
            return back();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kri = KriteriaMonev::orderBy('id', 'asc')->get();
        foreach ($kri as $key => $value) {
            if ($key == 1) {
                $kri_id = $value->id;
            }
        }
        $insMon = new DetailInstrumenMonev;
        $insMon->ins_monev_id = $request->get('idInsMon');
        $insMon->agd_id = $request->get('agd_id');
        $insMon->id_kri = $kri_id;
        $insMon->nilai = $request->get('nilai');
        $insMon->save();

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

    public function listMonev(){
        $nik = auth()->user()->nik;
        // Data Filters
        $fak = Fakultas::all();
        $prodi = Prodi::where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::all();

        $kar = KaryawanDosen::where('nik', $nik)->first();
        $smt = Semester::where('fak_id', $kar->fakul_id)->first();
        $pltMnv = PlottingMonev::with('programstudi')->where('nik_pemonev', $nik)->where('semester', $smt->smt_yad)->fakultas()->prodi()->dosen()->name()->paginate(6)->withQueryString();
        $arrPlot = $pltMnv->pluck('id')->toArray();
        $insMon = InstrumenMonev::whereIn('plot_monev_id', $arrPlot)->get();

        return view('instrumen-monev.list-monev', compact('pltMnv','insMon', 'fak', 'prodi', 'kary'));
    }
}
