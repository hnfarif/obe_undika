<?php

namespace App\Http\Controllers;

use App\Models\AgendaBelajar;
use App\Models\Clo;
use App\Models\DetailAgenda;
use App\Models\Llo;
use App\Models\MataKuliah;
use App\Models\MateriKuliah;
use App\Models\Penilaian;
use App\Models\Rps;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Rps $rps)
    {
        $agenda = DetailAgenda::whereHas('agendaBelajar', function($q) use ($rps){
            $q->where('rps_id', $rps->id);
        })->with('penilaian','agendaBelajar', 'clo', 'llo', 'materiKuliahs')
        ->distinct()
        ->get();

        // $agenda = AgendaBelajar::where('rps_id', $rps->id)->with('detailAgendas')->get();

        // dd($agenda);
        return view('rps.agenda.index', compact('rps','agenda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Rps $rps)
    {
        $week = AgendaBelajar::where('rps_id', $rps->id)->orderBy('id', 'asc')->count();
        $week++;

        $penilaian = Penilaian::where('rps_id', $rps->id)->orderBy('id','asc')->get();

        $clo = Clo::where('rps_id', $rps->id)->get();
        // session()->forget('listLlo');
        // session()->flush();
        $listLlo = session('listLlo-'.$rps->id);
        // dd(session('listmateri-'.$rps->id));
        // dd($listLlo);
        if (!$listLlo) {
            $listLlo = [];
        }

        if ($request->ajax()) {

            return DataTables::of($listLlo)
            ->editColumn('capai_llo', '{!! $capai_llo !!}')
            ->setRowAttr(['onmousedown' => 'return false;',
            'onselectstart' => 'return false;'])
            ->editColumn('btk_penilaian', function ($data){
                if ($data['btk_penilaian']) {

                    return '<b>'.$data['btk_penilaian'].' '.$data['bbt_penilaian'] .'% </b> <br>'.$data['des_penilaian'];
                }else{
                    return '-';
                }
            })
            ->editColumn('pbm', function ($data){

                $pbm = '';

                if (isset($data['pbm'])) {
                    foreach ($data['pbm'][0] as $key => $value) {
                        $pbm .= '- '.$value['desPbm']. '<br>';
                    }
                }

                return $pbm;
            })
            ->editColumn('materi', function ($data){

                $materi = '';
                $kajian = '';
                $pustaka = '';
                $media = '';

                if (isset($data['materi'])) {

                    foreach ($data['materi'][0] as $key => $value) {
                        $materi .= '- '.$value['materi'].'<br>';
                    }
                }
                if (isset($data['kajian'])) {

                    foreach ($data['kajian'][0] as $key => $value) {
                        $kajian .= '- '.$value['kajian'].'<br>';
                    }
                }

                if (isset($data['pustaka'])) {

                    foreach ($data['pustaka'][0] as $key => $value) {
                        $pustaka .= '- '.$value['judul'].', '.$value['bab'].', hal.'.$value['halaman'].'<br>';
                    }
                }

                if (isset($data['media'])) {
                    foreach ($data['media'][0] as $key => $value) {
                        $media .= '- '.$value['media'].'<br>';
                    }
                }

                return '<b>Kajian</b>:'.'<br>'.$kajian.'<br>'
                .'<b>Materi</b>:'.'<br>'.$materi.'<br>'
                .'<b>Pustaka</b>:'.'<br>'.$pustaka.'<br>'
                .'<b>Media Pembelajaran</b>:'.'<br>'.$media.'<br>';
            })
            ->editColumn('metode', function ($data){

                $metode = '';

                if (isset($data['metode'])) {
                    foreach ($data['metode'][0] as $key => $value) {
                        $metode .= '- '.$value['metode'].'<br>';
                    }
                }

                return $metode.'<br>';
            })
            ->addColumn('aksi', function ($data) {
                return '<button class="btn btn-danger deleteLlo" data-clo="'.$data['clo_id'].'" data-llo="'.$data['kode_llo'].'"><i class="fas fa-trash"></i>
                </button>';
            })->rawColumns(['capai_llo','btk_penilaian','pbm','materi','metode','aksi'])
            ->make(true);
        }
        return view('rps.agenda.create', compact('rps','week','clo', 'listLlo', 'penilaian'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Rps $rps)
    {
        $listLlo = session('listLlo-'.$rps->id);
        if (!$listLlo) {
            $listLlo = [];
        }

        if($listLlo){
            $agdBelajar = new AgendaBelajar;
            $agdBelajar->rps_id = $rps->id;
            $agdBelajar->pekan = $request->week;
            $agdBelajar->save();


            foreach ($listLlo as $key => $value) {

                if ($value['btk_penilaian']) {

                    $filPen = Penilaian::select('id')->where('rps_id', $rps->id)->where('btk_penilaian', $value['btk_penilaian'])->first();
                }else{
                    $filPen = (object) array("id" => null);
                }

                $filClo = Clo::where('rps_id', $rps->id)->where('kode_clo', $value['clo_id'])->first();

                $filLlo = LLo::where('rps_id', $rps->id)->where('kode_llo', $value['kode_llo'])->first();

                if (!$filLlo) {
                    $llo = new Llo;
                    $llo->kode_llo = $value['kode_llo'];
                    $llo->deskripsi = $value['des_llo'];
                    $llo->capaian = $value['capai_llo'];
                    $llo->rps_id = $rps->id;
                    $llo->save();
                    $filLlo = LLo::where('rps_id', $rps->id)->where('kode_llo', $value['kode_llo'])->first();
                }

                $dtlAgenda = new DetailAgenda;
                $dtlAgenda->agd_id = $agdBelajar->id;
                $dtlAgenda->clo_id = $filClo->id;
                $dtlAgenda->llo_id = $filLlo->id;
                $dtlAgenda->penilaian_id = $filPen->id;
                $dtlAgenda->bobot = $value['bbt_penilaian'];
                $dtlAgenda->deskripsi_penilaian = $value['des_penilaian'];
                $dtlAgenda->tm = $value['tm'];
                $dtlAgenda->sl = $value['sl'];
                $dtlAgenda->asl = $value['asl'];
                $dtlAgenda->asm = $value['asm'];
                $dtlAgenda->res_tutor = $value['responsi'];
                $dtlAgenda->bljr_mandiri = $value['belajarMandiri'];
                $dtlAgenda->praktikum = $value['prak'];
                $dtlAgenda->save();

                if(isset($value['pustaka'])){
                    foreach ($value['pustaka'][0] as $valPus) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->jdl_ptk = $valPus['judul'];
                        $materi->bab_ptk = $valPus['bab'];
                        $materi->hal_ptk = $valPus['halaman'];
                        $materi->status = 'pustaka';
                        $materi->save();
                    }
                }

                if(isset($value['media'])){
                    foreach ($value['media'][0] as $valMedia) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->media_bljr = $valMedia['media'];
                        $materi->status = 'media';
                        $materi->save();
                    }
                }

                if(isset($value['metode'])){
                    foreach ($value['metode'][0] as $valMetode) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->mtd_bljr = $valMetode['metode'];
                        $materi->status = 'metode';
                        $materi->save();
                    }
                }

                if(isset($value['pbm'])){
                    foreach ($value['pbm'][0] as $valPbm) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->deskripsi_pbm = $valPbm['desPbm'];
                        $materi->status = 'pbm';
                        $materi->save();
                    }
                }

                if(isset($value['materi'])){
                    foreach ($value['materi'][0] as $valMateri) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->materi = $valMateri['materi'];
                        $materi->status = 'materi';
                        $materi->save();
                    }
                }

                if(isset($value['kajian'])){
                    foreach ($value['kajian'][0] as $valKajian) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->kajian = $valKajian['kajian'];
                        $materi->status = 'kajian';
                        $materi->save();
                    }
                }

            }

        }else{
            $dtlAgenda = false;
        }

        session()->forget('listLlo-'.$rps->id);

        if ($dtlAgenda) {
            Session::flash('message','Data Agenda Pembelajaran berhasil ditambah pada minggu ke ' . $request->week);
            Session::flash('alert-class','alert-success');
        }else{
            Session::flash('message','Data Agenda Pembelajaran gagal ditambahkan.');
            Session::flash('alert-class','alert-danger');
        }

        return redirect()->route('agenda.index', $rps->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgendaBelajar  $agendaBelajar
     * @return \Illuminate\Http\Response
     */
    public function show(AgendaBelajar $agendaBelajar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AgendaBelajar  $agendaBelajar
     * @return \Illuminate\Http\Response
     */
    public function edit(AgendaBelajar $agendaBelajar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgendaBelajar  $agendaBelajar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgendaBelajar $agendaBelajar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgendaBelajar  $agendaBelajar
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgendaBelajar $agendaBelajar)
    {
        //
    }

    public function getSks(Request $request)
    {
        $rps = Rps::with('mataKuliah')->find($request->rps_id);

        return $rps;
    }

    public function listLlo(Request $request)
    {
        if ($request->btk_penilaian || $request->bbt_penilaian || $request->des_penilaian) {
            $validatedData =  Validator::make($request->all(), [
                'clo_id' => 'required',
                'kode_llo' => 'required|regex:/^LLO\d/',
                'des_llo' => 'required',
                'capai_llo' => 'required',
                'btk_penilaian' => 'required',
                'bbt_penilaian' => 'required',
                'des_penilaian' => 'required',
                'tm' => 'nullable',
                'sl' => 'nullable',
                'asl' => 'nullable',
                'asm' => 'nullable',
                'responsi' => 'nullable',
                'belajarMandiri' => 'nullable',
                'prak' => 'nullable',

            ]);
        }else{
            $validatedData =  Validator::make($request->all(), [
                'clo_id' => 'required',
                'kode_llo' => 'required|regex:/^LLO\d/',
                'des_llo' => 'required',
                'capai_llo' => 'required',
                'btk_penilaian' => 'nullable',
                'bbt_penilaian' => 'nullable',
                'des_penilaian' => 'nullable',
                'tm' => 'nullable',
                'sl' => 'nullable',
                'asl' => 'nullable',
                'asm' => 'nullable',
                'responsi' => 'nullable',
                'belajarMandiri' => 'nullable',
                'prak' => 'nullable',

            ]);
        }



        // dd($totalBtk);
        $listLlo = [];

        if ($validatedData->passes()) {

            $sumBtk = DetailAgenda::whereHas('agendaBelajar', function($query) use ($request){
                $query->where('rps_id', $request->rps_id);
            })->sum('bobot');

            $totalBtk = $sumBtk + $request->bbt_penilaian;

            if($totalBtk <= 100){
                if (session()->has('listLlo-'.$request->rps_id)) {

                    $dataLlo = session('listLlo-'.$request->rps_id);

                    foreach ($dataLlo as $item) {
                        if(!($item['clo_id'] == $request->clo_id && $item['kode_llo'] == $request->kode_llo)){
                            array_push($listLlo, $item);
                        }
                    }
                    array_push($listLlo, $request->all());
                    foreach($listLlo as $key => $i){
                        if ($i['clo_id'] == $request->clo_id && $i['kode_llo'] == $request->kode_llo) {
                            foreach ($request->status as $sts) {
                                if(session()->has('list'.$sts.'-'.$request->rps_id)){
                                    $dataMateri = session('list'.$sts.'-'.$request->rps_id);
                                    $listLlo[$key][$sts] = [];
                                    array_push($listLlo[$key][$sts], $dataMateri);

                                }

                            }
                        }

                    }

                }else{
                    array_push($listLlo, $request->all());
                    foreach($listLlo as $key => $i){
                        if ($i['clo_id'] == $request->clo_id && $i['kode_llo'] == $request->kode_llo) {
                            foreach ($request->status as $sts) {
                                if(session()->has('list'.$sts.'-'.$request->rps_id)){

                                    $dataMateri = session('list'.$sts.'-'.$request->rps_id);
                                    $listLlo[$key][$sts] = [];
                                    array_push($listLlo[$key][$sts], $dataMateri);

                                }

                            }
                        }

                    }

                }

                session(['listLlo-'.$request->rps_id => $listLlo]);
                return response()->json(['success' => 'Data berhasil Ditambahkan', 'listLlo' => $listLlo]);
            }else{
                return response()->json(['errBbt' => 'Maaf Data bobot yang anda masukkan akan melebihi 100% , Harap perbaiki data anda']);
            }

        }

        return response()->json(['error' => $validatedData->errors()->all()]);
    }

    public function deleteLlo(Request $request)
    {
        $listLlo = session('listLlo-'.$request->rps_id);

        foreach ($listLlo as $key => $item) {
            if($item['clo_id'] == $request->kodeClo && $item['kode_llo'] == $request->kodeLlo){
                unset($listLlo[$key]);
            }
        }

        session(['listLlo-'.$request->rps_id => $listLlo]);
        return response()->json(['success' => 'Data berhasil Dihapus']);
    }

    public function storeMateri(Request $request)
    {

        $listMateri = [];


        if($request->status == 'pustaka'){

            $validatedData =  Validator::make($request->all(), [

                'judul' => 'required',
                'bab' => 'required',
                'halaman' => 'required',

            ]);

            if ($validatedData->passes()) {

                $request->merge(['id' => uniqid()]);

                if (session()->has('list'.$request->status.'-'.$request->rps_id)) {

                    $dataMateri = session('list'.$request->status.'-'.$request->rps_id);

                    foreach ($dataMateri as $item) {

                        array_push($listMateri, $item);

                    }
                    array_push($listMateri, $request->all());
                }else{
                    array_push($listMateri, $request->all());
                }

                session(['list'.$request->status.'-'.$request->rps_id => $listMateri]);
                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }

        }else if($request->status == 'pbm'){
            $validatedData =  Validator::make($request->all(), [

                'desPbm' => 'required',

            ]);

            if ($validatedData->passes()) {

                if (session()->has('list'.$request->status.'-'.$request->rps_id)) {

                    $dataMateri = session('list'.$request->status.'-'.$request->rps_id);

                    foreach ($dataMateri as $item) {
                        if(!($item['desPbm'] == $request->desPbm)){
                            array_push($listMateri, $item);
                        }
                    }
                    array_push($listMateri, $request->all());
                }else{
                    array_push($listMateri, $request->all());
                }

                session(['list'.$request->status.'-'.$request->rps_id => $listMateri]);
                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }

        }else if($request->status === 'materi') {

            $validatedData =  Validator::make($request->all(), [

                'materi' => 'required',

            ]);

            if ($validatedData->passes()) {

                if (session()->has('list'.$request->status.'-'.$request->rps_id)) {

                    $dataMateri = session('list'.$request->status.'-'.$request->rps_id);

                    foreach ($dataMateri as $item) {
                        if(!($item['materi'] == $request->materi)){
                            array_push($listMateri, $item);
                        }
                    }
                    array_push($listMateri, $request->all());
                }else{
                    array_push($listMateri, $request->all());
                }

                session(['list'.$request->status.'-'.$request->rps_id => $listMateri]);
                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }
        }else if($request->status === 'kajian') {

            $validatedData =  Validator::make($request->all(), [

                'kajian' => 'required',

            ]);

            if ($validatedData->passes()) {

                if (session()->has('list'.$request->status.'-'.$request->rps_id)) {

                    $dataMateri = session('list'.$request->status.'-'.$request->rps_id);

                    foreach ($dataMateri as $item) {
                        if(!($item['kajian'] == $request->kajian)){
                            array_push($listMateri, $item);
                        }
                    }
                    array_push($listMateri, $request->all());
                }else{
                    array_push($listMateri, $request->all());
                }

                session(['list'.$request->status.'-'.$request->rps_id => $listMateri]);
                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }
        }else if($request->status === 'media') {

            $validatedData =  Validator::make($request->all(), [

                'media' => 'required',

            ]);

            if ($validatedData->passes()) {

                if (session()->has('list'.$request->status.'-'.$request->rps_id)) {

                    $dataMateri = session('list'.$request->status.'-'.$request->rps_id);

                    foreach ($dataMateri as $item) {
                        if(!($item['media'] == $request->media)){
                            array_push($listMateri, $item);
                        }
                    }
                    array_push($listMateri, $request->all());
                }else{
                    array_push($listMateri, $request->all());
                }

                session(['list'.$request->status.'-'.$request->rps_id => $listMateri]);
                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }
        }else if($request->status === 'metode') {

            $validatedData =  Validator::make($request->all(), [

                'metode' => 'required',

            ]);

            if ($validatedData->passes()) {

                if (session()->has('list'.$request->status.'-'.$request->rps_id)) {

                    $dataMateri = session('list'.$request->status.'-'.$request->rps_id);

                    foreach ($dataMateri as $item) {
                        if(!($item['metode'] == $request->metode)){
                            array_push($listMateri, $item);
                        }
                    }
                    array_push($listMateri, $request->all());
                }else{
                    array_push($listMateri, $request->all());
                }

                session(['list'.$request->status.'-'.$request->rps_id => $listMateri]);
                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }
        }

        return response()->json(['error' => $validatedData->errors()->all()]);
    }

    public function deleteMateri(Request $request)
    {
        $listMateri = session('list'.$request->status.'-'.$request->rps_id);

        if($request->status == 'pustaka'){
            foreach ($listMateri as $key => $item) {
                if($item['id'] == $request->id){
                    unset($listMateri[$key]);
                }
            }
        }else if($request->status == 'pbm'){
            foreach ($listMateri as $key => $item) {
                if($item['desPbm'] == $request->desPbm){
                    unset($listMateri[$key]);
                }
            }
        }else if($request->status == 'materi'){
            foreach ($listMateri as $key => $item) {
                if($item['materi'] == $request->materi){
                    unset($listMateri[$key]);
                }
            }
        }else if($request->status == 'kajian'){
            foreach ($listMateri as $key => $item) {
                if($item['kajian'] == $request->kajian){
                    unset($listMateri[$key]);
                }
            }
        }else if($request->status == 'media'){
            foreach ($listMateri as $key => $item) {
                if($item['media'] == $request->media){
                    unset($listMateri[$key]);
                }
            }
        }else if($request->status == 'metode'){
            foreach ($listMateri as $key => $item) {
                if($item['metode'] == $request->metode){
                    unset($listMateri[$key]);
                }
            }
        }else if($request->status == 'pbm'){
            foreach ($listMateri as $key => $item) {
                if($item['desPbm'] == $request->desPbm){
                    unset($listMateri[$key]);
                }
            }
        }

        session(['list'.$request->status.'-'.$request->rps_id => $listMateri]);
        return response()->json(['success' => 'Data berhasil Dihapus']);
    }

    public function getMateri(Request $request, $rps)
    {
        $listMateri = session('list'.$request->status.'-'.$rps);
        if (!$listMateri) {
            $listMateri = [];
        }

        if($request->status == 'materi'){

            return DataTables::of($listMateri)
            ->addColumn('aksi', function ($data) {
            return '<button class="btn btn-danger delMateri" data-materi="'.$data['materi'].'"><i class="fas fa-trash"></i></button>';
            })->rawColumns(['aksi'])
            ->make(true);

        }else if($request->status == 'kajian'){

            return DataTables::of($listMateri)
            ->addColumn('aksi', function ($data) {
            return '<button class="btn btn-danger delKajian" data-kajian="'.$data['kajian'].'"><i class="fas fa-trash"></i></button>';
            })->rawColumns(['aksi'])
            ->make(true);

        }else if($request->status == 'pustaka'){

            return DataTables::of($listMateri)
            ->addColumn('aksi', function ($data) {
            return '<button class="btn btn-danger delPustaka" data-pustaka="'.$data['id'].'"><i class="fas fa-trash"></i></button>';
            })->rawColumns(['aksi'])
            ->make(true);

        }else if($request->status == 'media'){

            return DataTables::of($listMateri)
            ->addColumn('aksi', function ($data) {
            return '<button class="btn btn-danger delMedia" data-media="'.$data['media'].'"><i class="fas fa-trash"></i></button>';
            })->rawColumns(['aksi'])
            ->make(true);

        }else if($request->status == 'metode'){

            return DataTables::of($listMateri)
            ->addColumn('aksi', function ($data) {
            return '<button class="btn btn-danger delMetode" data-metode="'.$data['metode'].'"><i class="fas fa-trash"></i></button>';
            })->rawColumns(['aksi'])
            ->make(true);

        }else if($request->status == 'pbm'){

            return DataTables::of($listMateri)
            ->editColumn('desPbm', '{!! $desPbm !!}')
            ->setRowAttr(['onmousedown' => 'return false;',
            'onselectstart' => 'return false;'])
            ->addColumn('aksi', function ($data) {
            return '<button class="btn btn-danger delPbm" data-pbm="'.$data['desPbm'].'"><i class="fas fa-trash"></i></button>';
            })->rawColumns(['desPbm','aksi'])
            ->make(true);

        }



    }


}