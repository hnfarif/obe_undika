<?php

namespace App\Http\Controllers;

use App\Models\BobotPenilaian;
use App\Models\Clo;
use App\Models\Penilaian;
use App\Models\Rps;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery\Undefined;

class PenilaianController extends Controller
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

    public function index(Rps $rps)
    {
        $penilaian = Penilaian::where('rps_id',$rps->id)->orderBy('id','asc')->get();
        $smt = $this->semester;
        return view('rps.penilaian', compact('rps', 'penilaian', 'smt'));
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

        $penilaian = new Penilaian();
        $penilaian->rps_id = $rps->id;
        $penilaian->btk_penilaian = $request->btk_penilaian;
        $penilaian->jenis= $request->jenis;
        $penilaian->save();

        if($penilaian){

            Session::flash('message', 'Data berhasil ditambahkan');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'Data gagal ditambahkan');
            Session::flash('alert-class', 'alert-danger');
        }


        return redirect()->route('penilaian.index', $rps->id);
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
    public function edit(Request $request)
    {
        $penilaian = Penilaian::findOrFail($request->id);

        return $penilaian;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = $request->validate([
            'btk_penilaian' => 'required',
            'jenis' => 'required',
        ]);

        $penilaian = Penilaian::where('id', $request->id)->update([
            'btk_penilaian' => $request->btk_penilaian,
            'jenis' => $request->jenis,
        ]);

        if($penilaian){
            Session::flash('message', 'Data berhasil diubah');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'Data gagal diubah');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect()->route('penilaian.index', $request->rps_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $penilaian = Penilaian::destroy($id);

        if($penilaian){
            Session::flash('message', 'Data berhasil dihapus');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'Data gagal dihapus');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect()->route('penilaian.index', $request->rps_id);
    }


}
