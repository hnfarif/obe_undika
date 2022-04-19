<?php

namespace App\Http\Controllers;

use App\Models\Clo;
use App\Models\MataKuliah;
use App\Models\Penilaian;
use App\Models\Plo;
use App\Models\PloClo;
use App\Models\Rps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Rps $rps)
    {

        $mk = MataKuliah::all();
        $prasyarat = MataKuliah::where('id',$rps->kurlkl_id)->pluck('prasyarat')->first();
        $exPra = explode(' ', $prasyarat);
        $clo = Clo::where('rps_id',$rps->id)->with('plos')->orderBy('id','asc')->get();
        $iteration = Clo::latest()->select('kode_clo')->where('rps_id',$rps->id)->pluck('kode_clo')->first();

        return view('rps.clo.index', compact('rps', 'mk', 'exPra', 'clo', 'iteration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Rps $rps)
    {
        $plo = Plo::all();

        $iteration = Clo::where('rps_id', $rps->id)->latest()->select('kode_clo')->pluck('kode_clo')->first();
        $num = substr($iteration, -2, 2);
        $num++;
        $ite_padded = sprintf("%02d", $num);

        return view('rps.clo.create', compact('rps','plo','ite_padded'));
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
            'kode_clo' => 'required',
            'deskripsi' => 'required',
            'ranah_capai' => 'required',
            'lvl_bloom' => 'required',
            'ploid' => 'required',
            'target_lulus' => 'required',
            'nilai_min' => 'required',
        ]);

        $impRanah = implode(' ', $request->ranah_capai);
        $impLvl = implode('', $request->lvl_bloom);


        $clo = new Clo;
        $clo->rps_id = $rps->id;
        $clo->kode_clo = $request->kode_clo;
        $clo->deskripsi = $request->deskripsi;
        $clo->ranah_capai = $impRanah;
        $clo->lvl_bloom = $impLvl;
        $clo->tgt_lulus = $request->target_lulus;
        $clo->nilai_min = $request->nilai_min;
        $clo->save();

        $plo = new Plo;

        if($clo){
            foreach ($request->ploid as $i) {
                $cek = Plo::whereHas('clos', function ($query) use ($i, $clo) {
                    $query->where('plo_id', $i);
                    $query->where('clo_id', $clo->id);
                })->first();

                if ($cek == null) {

                    $plo->clos()->attach([['plo_id' => $i, 'clo_id' => $clo->id]]);
                    Session::flash('message','Data berhasil ditambahkan');
                    Session::flash('alert-class','alert-success');
                }
            }
        }

        return redirect()->route('clo.index', $rps->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clo  $clo
     * @return \Illuminate\Http\Response
     */
    public function show(Clo $clo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clo  $clo
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $clo = Clo::findOrFail($request->get('id'));

        $plo = Plo::whereHas('clos', function ($query) use ($clo) {
            $query->where('clo_id', $clo->id);
        })->get();
        $allplo = Plo::all()->map->only('id','kode_plo','deskripsi');
        return response()->json([
            'clo' => $clo,
            'plo' => $plo,
            'allplo' => $allplo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clo  $clo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = $request->validate([
            'kode_clo' => 'required',
            'deskripsi' => 'required',
            'ranah_capai' => 'required',
            'lvl_bloom' => 'required',
            'ploid' => 'required',
            'target_lulus' => 'required',
            'nilai_min' => 'required',
        ]);

        $update = Clo::where('id', $request->get('id'))->update([
            'kode_clo' => $request->get('kode_clo'),
            'deskripsi' => $request->get('deskripsi'),
            'ranah_capai' => implode(' ', $request->get('ranah_capai')),
            'lvl_bloom' => implode('', $request->get('lvl_bloom')),
            'tgt_lulus' => $request->get('target_lulus'),
            'nilai_min' => $request->get('nilai_min'),
        ]);

        $plo = new Plo;
        foreach ($request->ploid as $i) {
            $cek = Plo::whereHas('clos', function ($query) use ($i, $request) {
                $query->where('plo_id', $i);
                $query->where('clo_id', $request->get('id'));
            })->first();

            if ($cek == null) {

                $plo->clos()->attach([['plo_id' => $i, 'clo_id' => $request->get('id')]]);
                Session::flash('message','Data berhasil diubah');
                Session::flash('alert-class','alert-success');
            }
        }

        if($update){
            Session::flash('message','Data berhasil diubah');
            Session::flash('alert-class','alert-success');
        }else{
            Session::flash('message','Data gagal diubah');
            Session::flash('alert-class','alert-danger');
        }
        return redirect()->route('clo.index', $request->get('rps_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clo  $clo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $plo, $clo)
    {

        if ($request->valDel === 'plo') {
            $ploclo = PloClo::where('plo_id', $plo)->where('clo_id', $clo)->delete();
            if (!$ploclo) {
                Session::flash('message','Data gagal dihapus');
                Session::flash('alert-class','alert-danger');
            }
            Session::flash('message','Data berhasil dihapus');
            Session::flash('alert-class','alert-success');


        } else {
            $clo = Clo::destroy($clo);
            if (!$clo) {
                Session::flash('message','Data gagal dihapus');
                Session::flash('alert-class','alert-danger');
            }
            Session::flash('message','Data berhasil dihapus');
            Session::flash('alert-class','alert-success');
        }

        return redirect()->route('clo.index', $request->rps_id);
    }
}
