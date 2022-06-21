<?php

namespace App\Http\Controllers;

use App\Models\AgendaBelajar;
use App\Models\DetailAgenda;
use App\Models\InstrumenNilai;
use App\Models\KaryawanDosen;
use App\Models\MataKuliah;
use App\Models\MateriKuliah;
use App\Models\Rps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Auth::user());
        $rps = Rps::with('matakuliah','karyawan')->get();
        $dosens = KaryawanDosen::all();
        return view('rps.index', ['rps' => $rps, 'dosens' => $dosens]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mk = MataKuliah::where('status', 1)->get();
        $dosens = KaryawanDosen::all();

        return view('rps.plottingmk', compact('mk','dosens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'rumpun_mk' => 'required',
            'ketua_rumpun' => 'required',
            'semester' => 'required',
            'mklist' => 'required',
        ]);

        // dd($request->all());

        foreach ($request->mklist as $i) {


            $mk = MataKuliah::where('id',$i)->first();
            $findRps = Rps::where('kurlkl_id', $i)->where('semester',$request->semester)->where('is_active', '1')->first();

            if ($findRps) {
                continue;
            }else{
                $rps = new Rps;
                $rps->kurlkl_id = $i;
                $rps->nik = $request->ketua_rumpun;
                $rps->nama_mk = $mk->nama;
                $rps->rumpun_mk = $request->rumpun_mk;
                $rps->semester = $request->semester;
                $rps->is_active = 1;
                $rps->save();

            }

            Session::flash('message', 'Data berhasil ditambahkan!');
            Session::flash('alert-class', 'alert-success');

        }


        return redirect()->route('rps.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rps  $rps
     * @return \Illuminate\Http\Response
     */
    public function show(Rps $rps)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rps  $rps
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $rps = Rps::with('karyawan')->findOrFail($request->get('id'));
        return response()->json($rps);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rps  $rps
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rps $rps)
    {
        // dd($request->all());

        if (isset($request->rps_id)) {

            $validation = $request->validate([
                'rumpun_mk' => 'required',
                'ketua_rumpun' => 'required',
                'semester' => 'required',
                'sts_aktif' => 'required',
            ]);

            $updateRps = Rps::where('id', $request->rps_id)->update(
                [
                    'rumpun_mk' => $request->rumpun_mk,
                    'nik' => $request->ketua_rumpun,
                    'semester' => $request->semester,
                    'is_active' => $request->sts_aktif,
                ]
            );

            if ($updateRps) {
                Session::flash('message', 'Data berhasil diubah!');
                Session::flash('alert-class', 'alert-success');
            } else {
                Session::flash('message', 'Data gagal diubah!');
                Session::flash('alert-class', 'alert-danger');
            }
            return redirect()->route('rps.index');

        }else {

            $validation = $request->validate([
                'deskripsi_mk' => 'required',
            ]);

            $updateRps = Rps::where('id', $rps->id)
                ->update(['deskripsi_mk' => $request->deskripsi_mk]);

            if ($updateRps) {
                Session::flash('message','Data berhasil diubah.');
                Session::flash('alert-class','alert-success');
            }else{
                Session::flash('message','Data gagal diubah.');
                Session::flash('alert-class','alert-danger');
            }
            return redirect()->route('clo.index', $rps->id);
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rps  $rps
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rps $rps)
    {
        //
    }

    public function rangkuman(Rps $rps)
    {

        $dataRps = Rps::where('id', $rps->id)->get();

        $kultot = DetailAgenda::whereHas('agendaBelajar', function($q) use ($rps){
            $q->where('rps_id', $rps->id);
        })
        ->select(DB::raw('SUM(tm) as tm, SUM(sl) as sl, SUM(asl) as asl, SUM(asm) as asm, SUM(praktikum) as prak'))
        ->get();

        $med = MateriKuliah::whereHas('detailAgenda', function($q) use ($rps){
            $q->whereHas('agendaBelajar', function($q) use ($rps){
                $q->where('rps_id', $rps->id);
            });
        })->select('media_bljr')->where('status', 'media')->distinct()->get();

        $pus = MateriKuliah::whereHas('detailAgenda', function($q) use ($rps){
            $q->whereHas('agendaBelajar', function($q) use ($rps){
                $q->where('rps_id', $rps->id);
            });
        })->select('jdl_ptk', 'bab_ptk', 'hal_ptk')->where('status', 'pustaka')->distinct()->get();

        $pbm = MateriKuliah::whereHas('detailAgenda', function($q) use ($rps){
            $q->whereHas('agendaBelajar', function($q) use ($rps){
                $q->where('rps_id', $rps->id);
            });
        })->select('deskripsi_pbm')->where('status', 'pbm')->distinct()->get();
        // dd($pus);
        return view('rps.rangkuman', compact('dataRps','rps','kultot','med','pus','pbm'));
    }

    public function saveFileRps(Request $request, $rps)
    {
        $validatedData =  Validator::make($request->all(), [
            'rps' => 'required|mimes:pdf|max:51200',
        ]);

        if ($validatedData->passes()) {

            $rps = Rps::findOrFail($rps)->update([
                'file_rps' => $request->file('rps')->store('rps-file'),
                'is_done' => '1',
            ]);

            if ($rps) {
                Session::flash('message', 'File Rps berhasil diupload!');
                Session::flash('alert-class', 'alert-success');
            } else {
                Session::flash('message', 'File Rps gagal diupload!');
                Session::flash('alert-class', 'alert-danger');
            }

            return redirect()->route('rps.index');
        }

        return redirect()->back()->withErrors($validatedData->errors());
    }
}
