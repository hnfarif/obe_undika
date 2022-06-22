<?php

namespace App\Http\Controllers;

use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\Rps;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PlottingMonevController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('plotting-monev.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // session()->forget('listMonev-'.auth()->user()->nik);
        $rps = Rps::where('is_active', '1')->where('semester', '202')->pluck('kurlkl_id')->toArray();

        $arrKlkl = [];
        foreach ($rps as $i) {
            $arrKlkl[] = substr($i, 5);
        }

        $jdwkul = JadwalKuliah::where('sts_kul', '1')->whereIn('klkl_id', $arrKlkl)->paginate(10);

        $kary = KaryawanDosen::where('fakul_id', '<>', null)->get();
        // dd($kary);
        // dd($jdwkul);

        return view('plotting-monev.create', compact('jdwkul', 'kary'));
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

    public function addDosenSession(Request $request)
    {
        $validatedData =  Validator::make($request->all(), [

            'dosPeng' => 'required',

        ]);

        $listMk = [];

        if ($validatedData->passes()) {



            if (session()->has('listMonev-'.$request->nikAdmin)) {

                $dataMk = session('listMonev-'.$request->nikAdmin);

                foreach ($dataMk as $item) {
                    if(!($item['dosPeng'] == $request->dosPeng && $item['mkId'] == $request->mkId)){
                        array_push($listMk, $item);
                    }
                }
                array_push($listMk, $request->all());
            }else{
                array_push($listMk, $request->all());
            }

            session(['listMonev-'.$request->nikAdmin => $listMk]);
            return response()->json(['success' => 'Data berhasil Ditambahkan']);
        }

        return response()->json(['error' => $validatedData->errors()->all()]);
    }

    public function getListMonev(Request $request)
    {
        $listMonev = session('listMonev-'.$request->nikAdm);
        if (!$listMonev) {
            $listMonev = [];
        }

        return DataTables::of($listMonev)
        ->addColumn('aksi', function ($data) {
        return '<button class="btn btn-danger delMonev'.'" data-nik="'.$data['dosPeng'].'" data-mk="'.$data['mkId'].'"><i class="fas fa-trash"></i></button>';
        })->rawColumns(['aksi'])
        ->make(true);
    }

    public function deleteMonev(Request $request)
    {
        $listMonev = session('listMonev-'.$request->nikAdmin);
        $listMonev = array_filter($listMonev, function ($item) use ($request) {
            return $item['dosPeng'] != $request->nik || $item['mkId'] != $request->mk;
        });
        session(['listMonev-'.$request->nikAdmin => $listMonev]);
        return response()->json(['success' => 'Data berhasil Dihapus']);
    }
}
