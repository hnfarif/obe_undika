<?php

namespace App\Http\Controllers;

use App\Models\PeoPlo;
use App\Models\Plo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $iteration = Plo::latest()->select('kode_plo')->pluck('kode_plo')->first();
        $num = substr($iteration, -2, 2);
        $num++;
        $ite_padded = sprintf("%02d", $num);

        $plo = Plo::all();

        $peoplo = PeoPlo::all()->pluck('plo_id')->toArray();

        return view('kelolapeoplo.kelolaplo', ["ite_padded" => $ite_padded, "plo" => $plo, "iteration" => $iteration, "peoplo" => $peoplo]);
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
        $validation = $request->validate([
            'kode_plo' => 'required|unique:plo|max:6',
            'desc_plo' => 'required',
        ]);


       $plo = new Plo;

       $plo->kode_plo = $request->kode_plo;
       $plo->deskripsi = $request->desc_plo;

       $plo->save();
       return redirect()->route('peoplo.plo')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plo  $plo
     * @return \Illuminate\Http\Response
     */
    public function show(Plo $plo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plo  $plo
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = Plo::findOrFail($request->get('id'));
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plo  $plo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plo $plo)
    {
        $validation = $request->validate([
            'deskripsi' => 'required',
        ]);

        $update = Plo::where('id', $request->get('id'))
            ->update($validation);

        if ($update) {
            Session::flash('success','Data berhasil diubah.');
        }else{
            Session::flash('error','Data gagal diubah.');
        }
        return redirect()->route('peoplo.plo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plo  $plo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plo = Plo::destroy($id);

        if ($plo) {
            Session::flash('success','Data berhasil dihapus.');
        }else{
            Session::flash('error','Data gagal dihapus.');
        }

        return redirect()->route('peoplo.plo');
    }
}
