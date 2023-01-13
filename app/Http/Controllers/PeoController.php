<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\KaryawanDosen;
use App\Models\Peo;
use App\Models\PeoPlo;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PeoController extends Controller
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

            $chkrole = Prodi::where('mngr_id', $user->nik)->where('sts_aktif', 'Y')->orderBy('id', 'asc')->first();
            $iteration = Peo::latest()->select('kode_peo')->where('fakul_id', $chkrole->id)->pluck('kode_peo')->first();

            $num = substr($iteration, -2, 2);
            $num++;
            $ite_padded = sprintf("%02d", $num);

            $peo = Peo::where('fakul_id', $chkrole->id)->with('plos')->get();
            $namaProdi = $chkrole->prodi->nama;
            return view('kelolapeoplo.kelolapeo', compact('ite_padded', 'peo', 'iteration', 'smt', 'namaProdi'));

        }else if($user->role == 'dosen'){

            $chkrole = KaryawanDosen::where('nik', $user->nik)->first();
            $peo = Peo::where('fakul_id', $chkrole->fakul_id)->with('plos')->get();
            $namaProdi = $chkrole->prodi->nama;
            return view('kelolapeoplo.kelolapeo', compact('peo', 'smt', 'namaProdi'));

        }else if ($user->role == 'dekan'){
            $fak = Fakultas::where('mngr_id', $user->nik)->first();
            $prodi = Prodi::where('sts_aktif', 'Y')->where('id_fakultas', $fak->id)->get();
            return view('kelolapeoplo.kelolapeo', compact('prodi', 'smt'));
        }else{
            $prodi = Prodi::where('sts_aktif', 'Y')->get();
            return view('kelolapeoplo.kelolapeo', compact('prodi', 'smt'));
        }

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
            'kode_peo' => 'required|max:6',
            'desc_peo' => 'required',
        ]);

        $user = Auth::user();
        $getProdi = Prodi::where('mngr_id', $user->nik)->orderBy('id', 'asc')->first();

        $peo = new Peo;

        $peo->fakul_id = $getProdi->id;
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
    public function detail()
    {
        $peo = Peo::where('fakul_id', request('id'))->with('plos')->get();
        $smt = $this->semester;
        return view('kelolapeoplo.role.peo.detail', compact('peo', 'smt'));
    }
}
