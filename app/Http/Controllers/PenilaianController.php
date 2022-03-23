<?php

namespace App\Http\Controllers;

use App\Models\BobotPenilaian;
use App\Models\Clo;
use App\Models\Penilaian;
use App\Models\Rps;
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
    public function index(Rps $rps)
    {
        $penilaian = Penilaian::where('rps_id',$rps->id)->orderBy('id','asc')->get();

        return view('rps.penilaian', compact('rps', 'penilaian'));
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

    // public function getTotal(Request $request)
    // {
    //     $ttl_bbt = [];
    //     $ttl_clo = 0;
    //     $ttl_btk = [];
    //     $bobot = $request->bobotClo;

    //     foreach ($bobot as $key => $value) {

    //         foreach ($value as $key2 => $value2) {
    //             if(!array_key_exists(2, $bobot[$key])){
    //                 $ttl_bbt[$key][0] = 0;
    //             }

    //             if ($key2 == 2) {

    //                 $ttl_bbt[$key][0] = intval($value2);

    //             }else if($key2 >2){
    //                 $ttl_bbt[$key][0] += intval($value2);

    //             }

    //         }
    //     }

    //     foreach ($ttl_bbt as $key => $value) {
    //         $ttl_clo += $value[0];
    //     }

    //     foreach ($bobot as $key => $value) {

    //         foreach ($value as $key2 => $value2) {

    //             if ($key2 >= 2) {
    //                if(!array_key_exists(($key2-2), $ttl_btk)){

    //                   $ttl_btk[$key2 - 2][0] = intval($value2);

    //                }else{
    //                     $ttl_btk[$key2 - 2][0] += intval($value2);
    //                }

    //             }

    //         }
    //     }


    //     return [$ttl_bbt, $ttl_clo, $ttl_btk];
    // }

    // public function updateBobot(Request $request)
    // {
    //    $btkNilai =  $request->btkNilai;
    //    $bobot =  $request->bobot;
    //    $clo =  $request->clo;

    //     foreach ($bobot as $key => $value) {

    //         foreach ($value as $key2 => $value2) {

    //             if($key2 >= 2){
    //                 foreach ($btkNilai as $keyBtk => $valueBtk) {


    //                     if(array_key_exists(($keyBtk + 2), $bobot[$key])){



    //                         BobotPenilaian::where('penilaian_id', $valueBtk)->where('clo_id', $bobot[$key][1])->update(['bobot' => $bobot[$key][($keyBtk + 2)]]);


    //                     }


    //                 }

    //             }

    //         }
    //     }

    //     foreach ($clo as $key => $value) {

    //         foreach ($value as $key2 => $value2) {

    //             if($key2 >= (2 + count($btkNilai))){
    //                 for($i = 0; $i < 2; $i++){


    //                     if(array_key_exists(($i + (2 + count($btkNilai))), $clo[$key])){



    //                         Clo::where('id', $clo[$key][1])
    //                         ->update([
    //                             'tgt_lulus' => $clo[$key][$i + (2 + count($btkNilai))] ?? null,
    //                             'nilai_min' => $clo[$key][$i + (3 + count($btkNilai))] ?? null,
    //                         ]);

    //                     }


    //                 }

    //             }



    //         }
    //     }

    //     return 'success';
    // }
}
