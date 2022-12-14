<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\InstrumenMonev;
use App\Models\InstrumenNilai;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\KriteriaMonev;
use App\Models\PlottingMonev;
use App\Models\Prodi;
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


    private $semester;

    public function __construct()
    {
        $this->semester = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
    }

    public function index()
    {
        // data filters
        $fak = Fakultas::all();
        $prodi = Prodi::where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::all();

        $getFtPro = $prodi->first();
        $smt = $this->semester;
        $pltMnv = PlottingMonev::where('semester', $smt)->fakultas()->prodi()->dosen()->name()->get();
        $kri = KriteriaMonev::all();
        return view('plotting-monev.index', compact('pltMnv', 'kri', 'fak', 'prodi', 'kary', 'smt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $smt = $this->semester;

        $jdwkul = JadwalKuliah::where('ruang_id', '<>', null)->get();

        $arrJdwkul = [];

        foreach ($jdwkul as $i) {
           $cek = PlottingMonev::where('klkl_id', $i->klkl_id)->where('nik_pengajar', $i->kary_nik)->where('kelas', $i->kelas)->where('semester', $smt)->first();
              if(!$cek){
                $arrJdwkul[] = $i;
              }
        }

        $jdwkul = $arrJdwkul;
        $kary = KaryawanDosen::where('kary_type', 'like', '%D%')->get();

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
            $smt =  Semester::orderBy('smt_yad', 'desc')->first();
            PlottingMonev::create([
                'nik_pemonev' => $request->dosen_pemonev,
                'nik_pengajar' => $expData[0],
                'klkl_id' => $expData[1],
                'prodi' => $expData[2],
                'kelas' => $expData[3],
                'semester' => $smt->smt_yad,

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
        $delete = PlottingMonev::findOrFail($id);
        $delete->delete();

        Session::flash('message', 'Data berhasil dihapus!');
        Session::flash('alert-class', 'alert-success');

        return back();
    }


    public function createCriteria()
    {
        $smt = $this->semester;
        return view('plotting-monev.create-criteria', compact('smt'));
    }

    public function showCriteria(Request $request)
    {
        $data = KriteriaMonev::findOrFail($request->get('id'));
        return response()->json($data);
    }

    public function storeCriteria(Request $request)
    {
        $validatedData = $request->validate([
            'kriteria_penilaian' => 'required',
            'kategori' => 'required',
            'bobot' => 'required',
            'deskripsi' => 'required',
        ]);

        $cnKriMon = KriteriaMonev::sum('bobot');

        if($cnKriMon < 100 && ($cnKriMon + $request->bobot <= 100)){
            KriteriaMonev::create([
                'kategori' => $request->kategori,
                'kri_penilaian' => $request->kriteria_penilaian,
                'deskripsi' => $request->deskripsi,
                'bobot' => $request->bobot,
            ]);

            Session::flash('message', 'Data berhasil ditambahkan!');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'Data Gagal ditambahkan karena jumlah bobot melebihi 100%!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect()->route('monev.plotting.index');
    }

    public function updateCriteria(Request $request)
    {
        $validation = $request->validate([
            'kri_penilaian' => 'required',
            'kategori' => 'required',
            'bobot' => 'required',
            'deskripsi' => 'required',
        ]);

        $update = KriteriaMonev::where('id', $request->get('id'))
        ->update($validation);

        if ($update) {
            Session::flash('message', 'Data Kriteria berhasil diubah!');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'Data Kriteria gagal diubah!');
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect()->route('monev.plotting.index');
    }

    public function deleteCriteria($id)
    {
        $kri = KriteriaMonev::destroy($id);

        if ($kri) {
            Session::flash('message', 'Data Kriteria berhasil dihapus!');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'Data Kriteria gagal diubah!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect()->route('monev.plotting.index');
    }

    public function detailPlot(Request $request)
    {
        $pltMnv = PlottingMonev::where('nik_pemonev', $request->get('nik'))->where('semester', $request->get('smt'))->paginate(6)->withQueryString();
        $kary = KaryawanDosen::where('nik',$request->get('nik') )->first();
        $arrPlot = $pltMnv->pluck('id')->toArray();
        $insMon = InstrumenMonev::whereIn('plot_monev_id', $arrPlot)->get();

        $smt = $this->semester;

        return view('plotting-monev.detail', compact('pltMnv', 'insMon', 'kary', 'smt'));
    }

}
