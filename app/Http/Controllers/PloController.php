<?php

namespace App\Http\Controllers;

use App\Models\KaryawanDosen;
use App\Models\PeoPlo;
use App\Models\Plo;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PloController extends Controller
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

    public function index()
    {
        $user = Auth::user();
        $smt = $this->semester;

        if($user->role == 'kaprodi'){

            $chkrole = Prodi::where('mngr_id', $user->nik)->first();

            $iteration = Plo::latest()->select('kode_plo')->where('fakul_id', $chkrole->id)->pluck('kode_plo')->first();
            $num = substr($iteration, -2, 2);
            $num++;
            $ite_padded = sprintf("%02d", $num);

            $plo = Plo::where('fakul_id', $chkrole->id)->with('peos')->get();

        }else if($user->role == 'dosen'){

            $chkrole = KaryawanDosen::where('nik', $user->nik)->first();
            $plo = Plo::where('fakul_id', $chkrole->fakul_id)->with('peos')->get();

            return view('kelolapeoplo.kelolaplo', compact('plo', 'smt'));
        }



        return view('kelolapeoplo.kelolaplo', ["ite_padded" => $ite_padded ?? '', "plo" => $plo, "iteration" => $iteration ?? '', "smt" => $smt]);
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
            'kode_plo' => 'required|max:6',
            'desc_plo' => 'required',
        ]);

        $user = Auth::user();
        $getProdi = Prodi::where('mngr_id', $user->nik)->first();

       $plo = new Plo;
       $plo->fakul_id = $getProdi->id;
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

    public function detail(){
        $plo = Plo::where('fakul_id',  request('id'))->with('peos')->get();
        $smt = $this->semester;
        return view('kelolapeoplo.role.plo.detail', compact('plo', 'smt'));
    }
}
