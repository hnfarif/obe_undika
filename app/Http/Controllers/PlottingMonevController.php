<?php

namespace App\Http\Controllers;

use App\Models\JadwalKuliah;
use App\Models\Rps;
use App\Models\Semester;
use Illuminate\Http\Request;

class PlottingMonevController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('plotting-monev.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $rps = Rps::where('is_active', '1')->where('semester', '202')->pluck('kurlkl_id')->toArray();

        $arrKlkl = [];
        foreach ($rps as $i) {
            $arrKlkl[] = substr($i, 5);
        }

        $jdwkul = JadwalKuliah::where('sts_kul', '1')->whereIn('klkl_id', $arrKlkl)->paginate(10);

        // dd($jdwkul);

        return view('plotting-monev.create', compact('jdwkul'));
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
}
