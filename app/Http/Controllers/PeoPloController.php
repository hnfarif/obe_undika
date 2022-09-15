<?php

namespace App\Http\Controllers;

use App\Models\KaryawanDosen;
use App\Models\Peo;
use App\Models\PeoPlo;
use App\Models\Plo;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

       $user = Auth::user();
        if($user->role == 'kaprodi'){

            $chkrole = Prodi::where('mngr_id', $user->nik)->first();

            $peo = Peo::where('fakul_id', $chkrole->id)->with('plos')->orderBy('id','asc')->get();
            $plo = Plo::where('fakul_id', $chkrole->id)->with('peos')->orderBy('id','asc')->get();
            $filPeo = $peo->pluck('id')->toArray();
            $mapping = PeoPlo::whereIn('peo_id', $filPeo)->get();

        }else if($user->role == 'dosen'){

            $chkrole = KaryawanDosen::where('nik', $user->nik)->first();
            $peo = Peo::where('fakul_id', $chkrole->fakul_id)->with('plos')->orderBy('id','asc')->get();
            $plo = Plo::where('fakul_id', $chkrole->fakul_id)->with('peos')->orderBy('id','asc')->get();
            $filPeo = $peo->pluck('id')->toArray();
            $mapping = PeoPlo::whereIn('peo_id', $filPeo)->get();

        }


       return view('kelolapeoplo.mapping.index', compact('peo', 'plo', 'mapping'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $getProdi = Prodi::where('mngr_id', $user->nik)->first();

        $plo =  Plo::where('fakul_id', $getProdi->id)->get();
        $peo = Peo::where('fakul_id', $getProdi->id)->orderBy('kode_peo', 'asc')->get();
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

            $plo = Plo::where('id', $i)->first();
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
        return redirect()->route('peoplo.map');
    }

    public function detail(){
        $peo = Peo::where('fakul_id', request('id'))->with('plos')->orderBy('id','asc')->get();
        $plo = Plo::where('fakul_id', request('id'))->with('peos')->orderBy('id','asc')->get();
        $filPeo = $peo->pluck('id')->toArray();
        $mapping = PeoPlo::whereIn('peo_id', $filPeo)->get();
        return view('kelolapeoplo.role.mapping.detail', compact('peo','plo', 'mapping'));
    }
}
