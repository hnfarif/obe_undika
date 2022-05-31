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
use App\Models\Penilaian;
use App\Models\Rps;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('instrumen-nilai.index', compact('jdwkul'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   $idIns = $request->get('ins');
        $instru = InstrumenNilai::where('id', $request->get('ins'))->first();

        $agd = AgendaBelajar::where('rps_id', $instru->rps_id)->pluck('id')->toArray();
        $dtlAgd = DetailAgenda::whereIn('agd_id', $agd)->with('penilaian','clo','detailInstrumenNilai')->orderby('clo_id', 'asc')->orderby('id', 'asc')->get();
        $krs = Krs::where('jkul_klkl_id', $instru->klkl_id)->with('mahasiswa')->get();

        $dtlInstru = DetailInstrumenNilai::where('ins_nilai_id', $instru->id)->get();

        // dd($dtlAgd);


        return view('instrumen-nilai.nilaimhs', compact('dtlAgd','krs', 'dtlInstru', 'idIns'));
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

            $findDtlIns = DetailInstrumenNilai::where('mhs_nim', $n['nim'])->where('dtl_agd_id', $n['dtl_id'])->first();

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
            $instru = InstrumenNilai::where('rps_id', $rps->id)->where('klkl_id', substr($request->kode_mk, 5))->first();

            if ($instru) {
                return response()->json([
                    'url' => route('penilaian.clo.create', ['ins' => $instru->id ]),
                ]);

            }else{
                $newInstru = InstrumenNilai::create([
                    'rps_id' => $rps->id,
                    'klkl_id' => substr($request->kode_mk, 5),
                    'semester' => $smt->smt_aktif,
                ]);

                return response()->json([
                    'url' => route('penilaian.clo.create', ['ins' => $newInstru->id ]),
                ]);
            }

        }
    }
}
