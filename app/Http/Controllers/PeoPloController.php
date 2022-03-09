<?php

namespace App\Http\Controllers;

use App\Models\Peo;
use App\Models\PeoPlo;
use App\Models\Plo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PeoPloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $plo =  Plo::all();
       $peo = Peo::whereHas('plos')->orderBy('kode_peo', 'asc')->get();

       return view('kelolapeoplo.mapping.index', ['plo' => $plo, 'peo' => $peo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plo =  Plo::all();
        $peo = Peo::orderBy('kode_peo', 'asc')->get();
        return view('kelolapeoplo.mapping.create' , ['plo' => $plo, 'peo' => $peo,]);
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
            'kode_peo' => 'required',
            'plolist' => 'required',
        ]);

        $peo = new Peo;

        foreach ($request->plolist as $i) {

            $plo = Plo::where('kode_plo', $i)->first();
            $cek = Peo::whereHas('plos', function ($query) use ($plo, $request) {
                $query->where('peo_id', $request->kode_peo);
                $query->where('plo_id', $plo->id);
            })->first();

            if($cek == null){

                $peo->plos()->attach([['peo_id' => $request->kode_peo,'plo_id' => $plo->id]]);
                Session::flash('message','Data berhasil ditambahkan');
                Session::flash('alert-class','alert-success');
            }

        }
        return redirect()->route('peoplo.map');

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
    public function destroy($peo,$plo)
    {
        $peoplo = PeoPlo::where('peo_id', $peo)->where('plo_id', $plo)->delete();

        if ($peoplo) {
            Session::flash('message','Data berhasil dihapus.');
            Session::flash('alert-class','alert-success');
        }else{
            Session::flash('message','Data gagal dihapus.');
            Session::flash('alert-class','alert-danger');
        }
        return redirect()->route('peoplo.map')->with('success', 'Data berhasil ditambahkan');
    }
}
