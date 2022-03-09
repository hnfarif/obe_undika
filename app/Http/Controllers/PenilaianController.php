<?php

namespace App\Http\Controllers;

use App\Models\Clo;
use App\Models\Penilaian;
use App\Models\Rps;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Rps $rps)
    {
        $clo = Clo::where('rps_id',$rps->id)->orderBy('kode_clo', 'asc')->get();

        return view('rps.penilaian', compact('rps', 'clo'));
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
    public function store(Request $request, Rps $rps)
    {
        $validatedData = $request->validate([
            'btk_penilaian' => 'required',
            'jenis' => 'required',
        ]);

        $penilaian = new Penilaian;
        $penilaian->rps_id = $rps->id;
        $penilaian->nilai = $request->nilai;
        $penilaian->komentar = $request->komentar;
        $penilaian->save();

        return redirect()->route('rps.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function show(Penilaian $penilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function edit(Penilaian $penilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penilaian $penilaian)
    {
        //
    }

    public function getClo(Request $request, Rps $rps)
    {
        $clo = Clo::where('rps_id', $rps->id)->orderBy('kode_clo', 'asc')->get()->toArray();

        $output = [
            "draw" => $request->draw,
            "recordsTotal" => count($clo),
            "recordsFiltered" => count($clo),
            "data" => $clo
        ];

        return response()->json($output);
    }

}
