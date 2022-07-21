<?php

namespace App\Http\Controllers;

use App\Models\AgendaBelajar;
use App\Models\DetailAgenda;
use App\Models\DetailInstrumenMonev;
use App\Models\InstrumenMonev;
use App\Models\InstrumenNilai;
use App\Models\KriteriaMonev;
use App\Models\PlottingMonev;
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
            $cekInsMon = InstrumenMonev::where('plot_monev_id', $request->get('id'))->first();

            if(!$cekInsMon){
                $insMon = new InstrumenMonev;
                $insMon->plot_monev_id = $request->get('id');
                $insMon->ins_nilai_id = $cekInsNilai->id;
                $insMon->save();
            }
            $kri = KriteriaMonev::all();
            $agd = AgendaBelajar::where('rps_id', $cekInsNilai->rps_id)->get();
            $dtlAgd = DetailAgenda::whereIn('agd_id', $agd->pluck('id')->toArray())->with('penilaian','clo','detailInstrumenNilai','agendaBelajar')->orderby('clo_id', 'asc')->orderby('id', 'asc')->get();
            $dtlInsMon = DetailInstrumenMonev::where('ins_monev_id', $cekInsMon->id)->get();
            // dd($dtlAgd);
            return view('instrumen-monev.index', compact('agd','kri','dtlAgd', 'dtlInsMon'));
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
