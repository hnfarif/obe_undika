<?php

namespace App\Http\Controllers;

use App\Models\Peo;
use App\Models\PeoPlo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $iteration = Peo::latest()->select('kode_peo')->pluck('kode_peo')->first();
        $num = substr($iteration, -2, 2);
        $num++;
        $ite_padded = sprintf("%02d", $num);

        $peo = Peo::all();

        $peoplo = PeoPlo::all()->pluck('peo_id')->toArray();

        return view('kelolapeoplo.kelolapeo', ["ite_padded" => $ite_padded, "peo" => $peo, "iteration" => $iteration, "peoplo" => $peoplo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'kode_peo' => 'required|unique:peo|max:6',
            'desc_peo' => 'required',
        ]);


       $peo = new Peo;

       $peo->kode_peo = $request->kode_peo;
       $peo->deskripsi = $request->desc_peo;

       $peo->save();

       return redirect()->route('peoplo.peo')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peo  $peo
     * @return \Illuminate\Http\Response
     */
    public function show(Peo $peo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peo  $peo
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = Peo::findOrFail($request->get('id'));
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peo  $peo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peo $peo)
    {
        $validation = $request->validate([
            'deskripsi' => 'required',
        ]);

        $update = Peo::where('id', $request->get('id'))
            ->update($validation);

        if ($update) {
            Session::flash('success','Data berhasil diubah.');
        }else{
            Session::flash('error','Data gagal diubah.');
        }
        return redirect()->route('peoplo.peo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peo  $peo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peo = Peo::destroy($id);

        if ($peo) {
            Session::flash('success','Data berhasil dihapus.');
        }else{
            Session::flash('error','Data gagal dihapus.');
        }

        return redirect()->route('peoplo.peo');
    }
}
