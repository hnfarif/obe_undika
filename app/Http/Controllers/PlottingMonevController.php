<?php

namespace App\Http\Controllers;

use App\Models\InstrumenNilai;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\KriteriaMonev;
use App\Models\PlottingMonev;
use App\Models\Rps;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PlottingMonevController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nik = auth()->user()->nik;
        $pltMnv = PlottingMonev::where('nik_pemonev', $nik)->get();
        $kri = KriteriaMonev::all();
        return view('plotting-monev.index', compact('pltMnv', 'kri'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // session()->forget('listMonev-'.auth()->user()->nik);
        $rpsKl = Rps::where('is_active', '1')->pluck('kurlkl_id')->toArray();
        $rps = Rps::where('is_active', '1')->pluck('semester')->toArray();
        $plot = PlottingMonev::whereIn('semester', $rps)->get();
        // dd($plot);
        $arrJdwkul = [];

        foreach ($rpsKl as $i) {
            $arrKurlkl[] = substr($i,5);
        }

        $jdwkul = JadwalKuliah::whereIn('klkl_id', $arrKurlkl)->get();

        // dd($jdwkul);

        foreach ($jdwkul as $i) {
           $cek = PlottingMonev::where('klkl_id', $i->klkl_id)->where('nik_pengajar', $i->kary_nik)->first();
              if(!$cek){
                $arrJdwkul[] = $i;
              }
        }
        // dd($arrJdwkul);
        $jdwkul = $arrJdwkul;
        $kary = KaryawanDosen::where('fakul_id', '<>', null)->get();

        $smt = Semester::all();

        // dd($jdwkul);

        return view('plotting-monev.create', compact('jdwkul', 'kary', 'smt'));
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
        $validatedData = $request->validate([
            'dosen_pemonev' => 'required',
            'mk_monev' => 'required',
        ]);
        foreach ($request->mk_monev as $i) {
            $expData = explode("-", $i);
            $smt = Semester::where('fak_id', $expData[2])->first();
            PlottingMonev::create([
                'nik_pemonev' => $request->dosen_pemonev,
                'nik_pengajar' => $expData[0],
                'klkl_id' => $expData[1],
                'prodi' => $expData[2],
                'semester' => $smt->smt_aktif,

            ]);
        }

        Session::flash('message', 'Data berhasil ditambahkan!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('monev.plotting.index');
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


    public function createCriteria()
    {

        return view('plotting-monev.create-criteria');
    }

    public function storeCriteria(Request $request)
    {
        $validatedData = $request->validate([
            'kriteria_penilaian' => 'required',
            'kategori' => 'required',
            'bobot' => 'required',
            'deskripsi' => 'required',
        ]);

        KriteriaMonev::create([
            'kategori' => $request->kategori,
            'kri_penilaian' => $request->kriteria_penilaian,
            'deskripsi' => $request->deskripsi,
            'bobot' => $request->bobot,
        ]);

        Session::flash('message', 'Data berhasil ditambahkan!');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('monev.plotting.index');
    }

}
