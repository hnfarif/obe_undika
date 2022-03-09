<?php

namespace App\Http\Controllers;

use App\Models\KaryawanDosen;
use App\Models\MataKuliah;
use App\Models\Rps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rps = Rps::all();
        return view('rps.index', ['rps' => $rps]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mk = MataKuliah::all();
        $dosen = KaryawanDosen::all();
        return view('rps.plottingmk', ['mk' => $mk, 'dosen' => $dosen]);
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
            'mklist' => 'required',
        ]);

        // dd($request->all());

        foreach ($request->mklist as $i) {
            $rps = new Rps;
            $mk = MataKuliah::where('nama',$i)->first();
            $dosen = KaryawanDosen::where('nik',$request->ketua_rumpun)->first();
            $rps->kurlkl_id = $mk->id;
            $rps->nik = $dosen->nik;
            $rps->nama_mk = $i;
            $rps->rumpun_mk = $request->rumpun_mk;
            $rps->ketua_rumpun = $dosen->nama;
            $rps->semester = $mk->semester;
            $rps->sks = $mk->sks;
            $rps->save();

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
    public function edit(Rps $rps)
    {

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
        $validation = $request->validate([
            'deskripsi_mk' => 'required',
            'prasyarat' => 'required',
        ]);

        $prasyarat = implode(' ', $request->prasyarat);

        $updateRps = Rps::where('id', $rps->id)
            ->update(['deskripsi_mk' => $request->deskripsi_mk]);

        $updateMk = MataKuliah::where('id', $rps->kurlkl_id)
            ->update(['prasyarat' => $prasyarat]);

        if ($updateRps && $updateMk) {
            Session::flash('message','Data berhasil diubah.');
            Session::flash('alert-class','alert-success');
        }else{
            Session::flash('message','Data gagal diubah.');
            Session::flash('alert-class','alert-danger');
        }

        return redirect()->route('clo.index', $rps->id);
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
}
