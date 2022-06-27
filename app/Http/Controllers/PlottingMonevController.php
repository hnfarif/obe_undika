<?php

namespace App\Http\Controllers;

use App\Models\InstrumenNilai;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\PlottingMonev;
use App\Models\Rps;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        $nik = auth()->user()->nik;
        $pltMnv = PlottingMonev::where('nik_pemonev', $nik)->get();
        return view('plotting-monev.index', compact('pltMnv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // session()->forget('listMonev-'.auth()->user()->nik);
        $rps = Rps::where('is_active', '1')->pluck('kurlkl_id')->toArray();

        $arrKlkl = [];
        foreach ($rps as $i) {
            $arrKlkl[] = substr($i, 5);
        }

        $jdwkul = JadwalKuliah::where('sts_kul', '1')->whereIn('klkl_id', $arrKlkl)->get();

        $kary = KaryawanDosen::where('fakul_id', '<>', null)->get();

        $instru = InstrumenNilai::all();

        return view('plotting-monev.create', compact('jdwkul', 'kary', 'instru'));
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
            'dosen_pemonev' => 'required',
        ]);

        $listMonev = session('listMonev-'.$request->nikAdm) ?? [];

        if ($listMonev != []) {

            foreach ($listMonev as $i) {

                $instru = InstrumenNilai::where('klkl_id', $i['mkId'])->where('nik', $i['dosPeng'])->first();

                if($instru){
                    PlottingMonev::create([
                        'ins_nilai_id' => $instru->id,
                        'nik_pemonev' => $request->dosen_pemonev,
                        'nik_pengajar' => $i['dosPeng'],
                        'klkl_id' => $i['mkId'],
                        'prodi' => $i['prodi'],

                    ]);
                }
            }
        }else{
            Session::flash('message', 'Daftar Mata Kuliah yang di monev tidak boleh kosong!');
            Session::flash('alert-class', 'alert-danger');
            return back();
        }
        Session::flash('message', 'Data berhasil ditambahkan!');
        Session::flash('alert-class', 'alert-success');
        session()->forget('listMonev-'.auth()->user()->nik);
        return redirect()->route('monev.plotting.index');
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
        return '<button type="button" class="btn btn-danger delMonev" data-nik="'.$data['dosPeng'].'" data-mk="'.$data['mkId'].'"><i class="fas fa-trash"></i></button>';
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
