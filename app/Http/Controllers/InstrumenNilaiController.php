<?php

namespace App\Http\Controllers;

use App\Models\Clo;
use App\Models\JadwalKuliah;
use App\Models\Krs;
use App\Models\Penilaian;
use App\Models\Rps;
use Illuminate\Http\Request;

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
        // dd($nik_kary);
        $jdwkul = JadwalKuliah::where('kary_nik', $nik_kary)->get();
        return view('instrumen-nilai.index', compact('jdwkul'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $clo = Clo::where('rps_id', $request->get('rps_id'))->get();
        $penilaian = Penilaian::where('rps_id', $request->get('rps_id'))->orderBy('id', 'asc')->get();
        $krs = Krs::where('jkul_klkl_id', $request->get('klkl_id'))->get();

        return view('instrumen-nilai.nilaimhs', compact('clo', 'penilaian', 'krs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $rps = Rps::where('kurlkl_id', $request->kode_mk)->where('is_active', '1')->get();

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
            return response()->json([
                'rps' => $rps,
                'url' => route('instrumen.nilai.create', ['rps_id' => $rps->id]),
                'klkl_id' => substr($request->kode_mk, 5),
            ]);
        }
    }
}
