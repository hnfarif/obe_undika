<?php

namespace App\Http\Controllers;

use App\Models\AgendaBelajar;
use App\Models\Clo;
use App\Models\DetailAgenda;
use App\Models\Llo;
use App\Models\MataKuliah;
use App\Models\MateriKuliah;
use App\Models\MingguKuliah;
use App\Models\Penilaian;
use App\Models\Rps;
use App\Models\Semester;
use Carbon\Carbon;
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

    private $semester;

    public function __construct()
    {
        $this->semester = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
    }

    public function index(Rps $rps)
    {
        $agenda = DetailAgenda::whereHas('agendaBelajar', function($q) use ($rps){
            $q->where('rps_id', $rps->id);
        })->with('penilaian','agendaBelajar', 'clo', 'llo', 'materiKuliahs')
        ->orderBy('agd_id', 'asc')
        ->orderBy('clo_id', 'asc')
        ->get();

        $clo = Clo::where('rps_id', $rps->id)->orderBy('id')->get();
        $penilaian = Penilaian::where('rps_id', $rps->id)->get();
        $llo = Llo::where('rps_id', $rps->id)->orderBy('id','asc')->get();
        // $agenda = AgendaBelajar::where('rps_id', $rps->id)->with('detailAgendas')->get();
        $smt = $this->semester;
        // dd($agenda);
        return view('rps.agenda.index', compact('rps','agenda','clo','llo', 'penilaian', 'smt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Rps $rps)
    {
        $smt = $this->semester;
        $penilaian = Penilaian::where('rps_id', $rps->id)->orderBy('id','asc')->get();

        $clo = Clo::where('rps_id', $rps->id)->orderBy('id','asc')->get();
        $llo = Llo::where('rps_id', $rps->id)->orderBy('id','asc')->get();
        // session()->forget('listLlo');
        // session()->flush();
        $listLlo = session('listLlo-'.$rps->id);
        // dd(session('listmateri-'.$rps->id));
        // dd($listLlo);
        if (!$listLlo) {
            $listLlo = [];
        }


        // dd($uniqueLlo);
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
                    foreach ($data['pbm'] as $key => $value) {
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

                    foreach ($data['materi'] as $key => $value) {
                        $materi .= '- '.$value['materi'].'<br>';
                    }
                }
                if (isset($data['kajian'])) {

                    foreach ($data['kajian'] as $key => $value) {
                        $kajian .= '- '.$value['kajian'].'<br>';
                    }
                }

                if (isset($data['pustaka'])) {

                    foreach ($data['pustaka'] as $key => $value) {
                        $pustaka .= '- '.$value['judul'].', bab '.$value['bab'].', hal '.$value['halaman'].'<br>';
                    }
                }

                if (isset($data['media'])) {
                    foreach ($data['media'] as $key => $value) {
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
                    foreach ($data['metode'] as $key => $value) {
                        $metode .= '- '.$value['metode'].'<br>';
                    }
                }

                return $metode.'<br>';
            })
            ->addColumn('aksi', function ($data) {
                return '<button class="btn btn-danger deleteLlo" data-id="'.$data['idRow'].'"><i class="fas fa-trash"></i>
                </button>';
            })->rawColumns(['capai_llo','btk_penilaian','pbm','materi','metode','aksi'])
            ->make(true);
        }
        return view('rps.agenda.create', compact('rps','clo','llo', 'listLlo', 'penilaian', 'smt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Rps $rps)
    {

        $this->validate($request, [
            'week' => 'required',
        ]);

        $listLlo = session('listLlo-'.$rps->id);
        if (!$listLlo) {
            $listLlo = [];
        }

        if($listLlo){
            $fAgd = AgendaBelajar::where('rps_id', $rps->id)->where('pekan', $request->week)->first();
            if (!$fAgd) {
                if ($request->week == 8) {
                    $getPreWeek = $request->week + 1;
                    $kul = MingguKuliah::where('jenis_smt', 'T')->where('smt', $rps->semester)->where('minggu_ke', $getPreWeek)->first()->tgl_awal;

                    $tglAwal = Carbon::parse($kul)->subDays(14)->format('Y-m-d');

                    $agdBelajar = new AgendaBelajar;
                    $agdBelajar->rps_id = $rps->id;
                    $agdBelajar->pekan = $request->week;
                    $agdBelajar->tgl_nilai = $tglAwal;
                    $agdBelajar->save();
                }else if ($request->week == 16) {
                    $getPreWeek = $request->week - 1;
                    $kul = MingguKuliah::where('jenis_smt', 'T')->where('smt', $rps->semester)->where('minggu_ke', $getPreWeek)->first()->tgl_awal;

                    $tglAwal = date('Y-m-d', strtotime('+7 days', strtotime($kul)));

                    $agdBelajar = new AgendaBelajar;
                    $agdBelajar->rps_id = $rps->id;
                    $agdBelajar->pekan = $request->week;
                    $agdBelajar->tgl_nilai = $tglAwal;
                    $agdBelajar->save();
                }else{
                    $kul = MingguKuliah::where('jenis_smt', 'T')->where('smt', $rps->semester)->where('minggu_ke', $request->week)->first();
                    $agdBelajar = new AgendaBelajar;
                    $agdBelajar->rps_id = $rps->id;
                    $agdBelajar->pekan = $request->week;
                    $agdBelajar->tgl_nilai = $kul->tgl_awal;
                    $agdBelajar->save();
                }
            }


            foreach ($listLlo as $key => $value) {

                if ($value['btk_penilaian']) {

                    $filPen = Penilaian::select('id')->where('rps_id', $rps->id)->where('btk_penilaian', $value['btk_penilaian'])->first();
                }else{
                    $filPen = (object) array("id" => null);
                }

                $filClo = Clo::where('rps_id', $rps->id)->where('kode_clo', $value['clo_id'])->first();

                if ($value['kode_llo']) {
                    $filLlo = LLo::where('rps_id', $rps->id)->where('kode_llo', $value['kode_llo'])->first();

                    if (!$filLlo) {
                        if($value['prak']){
                            $llo = new Llo;
                            $llo->kode_llo = $value['kode_llo'];
                            $llo->deskripsi = null;
                            $llo->deskripsi_prak =  $value['des_llo'];
                            $llo->rps_id = $rps->id;
                            $llo->save();
                            $filLlo = LLo::where('rps_id', $rps->id)->where('kode_llo', $value['kode_llo'])->first();
                        }else{
                            $llo = new Llo;
                            $llo->kode_llo = $value['kode_llo'];
                            $llo->deskripsi = $value['des_llo'];
                            $llo->deskripsi_prak =  null;
                            $llo->rps_id = $rps->id;
                            $llo->save();
                            $filLlo = LLo::where('rps_id', $rps->id)->where('kode_llo', $value['kode_llo'])->first();
                        }

                    }else{
                        if($value['prak']){
                            LLo::where('rps_id', $rps->id)->where('kode_llo', $value['kode_llo'])->update([
                                 'deskripsi_prak' => $value['des_llo'],
                             ]);

                        }else{
                            LLo::where('rps_id', $rps->id)->where('kode_llo', $value['kode_llo'])->update([
                                'deskripsi' => $value['des_llo'],
                            ]);
                        }
                    }

                }else{
                    $filLlo = '';
                }

                $dtlAgenda = new DetailAgenda;
                if ($fAgd) {

                    $dtlAgenda->agd_id = $fAgd->id;
                }else{
                    $dtlAgenda->agd_id = $agdBelajar->id;

                }
                $dtlAgenda->clo_id = $filClo->id;
                $dtlAgenda->llo_id = ($filLlo) ? $filLlo->id : null;
                $dtlAgenda->penilaian_id = $filPen->id;
                $dtlAgenda->bobot = $value['bbt_penilaian'];
                $dtlAgenda->capaian_llo = $value['capai_llo'];
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
                    foreach ($value['pustaka'] as $valPus) {
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
                    foreach ($value['media'] as $valMedia) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->media_bljr = $valMedia['media'];
                        $materi->status = 'media';
                        $materi->save();
                    }
                }

                if(isset($value['metode'])){
                    foreach ($value['metode'] as $valMetode) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->mtd_bljr = $valMetode['metode'];
                        $materi->status = 'metode';
                        $materi->save();
                    }
                }

                if(isset($value['pbm'])){
                    foreach ($value['pbm'] as $valPbm) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->deskripsi_pbm = $valPbm['desPbm'];
                        $materi->status = 'pbm';
                        $materi->save();
                    }
                }

                if(isset($value['materi'])){
                    foreach ($value['materi'] as $valMateri) {
                        $materi = new MateriKuliah;
                        $materi->dtl_agd_id = $dtlAgenda->id;
                        $materi->materi = $valMateri['materi'];
                        $materi->status = 'materi';
                        $materi->save();
                    }
                }

                if(isset($value['kajian'])){
                    foreach ($value['kajian'] as $valKajian) {
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
            Session::flash('message','Data Agenda Pembelajaran Kosong.');
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
    public function edit(Request $request)
    {
        $dtlAgd = DetailAgenda::with('agendaBelajar','clo','llo', 'penilaian')->findOrFail($request->get('id'));

        return response()->json($dtlAgd);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgendaBelajar  $agendaBelajar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cekDa = DetailAgenda::where('id', $request->idDtl)->first();
        $cekPekan = AgendaBelajar::where('id', $cekDa->agd_id)->first()->pekan;

        if($cekPekan == '8' || $cekPekan == '16'){
            $validatedData =  Validator::make($request->all(), [
                'clo_id' => 'required',
                'kode_llo' => 'nullable',
                'des_llo' => 'nullable',
                'capai_llo' => 'nullable',
                'btk_penilaian' => 'required_with:bbt_penilaian,des_penilaian',
                'bbt_penilaian' => 'required_with:btk_penilaian',
                'des_penilaian' => 'required_with:btk_penilaian',
                'tm' => 'required_without_all:sl,asl,asm,prak',
                'sl' => 'required_without_all:tm,asl,asm,prak',
                'asl' => 'required_without_all:tm,sl,asm,prak',
                'asm' => 'required_without_all:tm,sl,asl,prak',
                'responsi' => 'nullable',
                'belajarMandiri' => 'nullable',
                'prak' => 'required_if:isPrak,"1"',

            ]);
        }else{
            $validatedData =  Validator::make($request->all(), [
                'clo_id' => 'required',
                'kode_llo' => 'required',
                'des_llo' => 'required',
                'capai_llo' => 'required',
                'btk_penilaian' => 'required_with:bbt_penilaian,des_penilaian',
                'bbt_penilaian' => 'required_with:btk_penilaian',
                'des_penilaian' => 'required_with:btk_penilaian',
                'tm' => 'required_without_all:sl,asl,asm,prak',
                'sl' => 'required_without_all:tm,asl,asm,prak',
                'asl' => 'required_without_all:tm,sl,asm,prak',
                'asm' => 'required_without_all:tm,sl,asl,prak',
                'responsi' => 'nullable',
                'belajarMandiri' => 'nullable',
                'prak' => 'required_if:isPrak,"1"',

            ]);
        }


        if ($validatedData->passes()) {

            $sumBtk = DetailAgenda::whereHas('agendaBelajar', function($query) use ($request){
                $query->where('rps_id', $request->rps_id);
            })->sum('bobot');

            $totalBtk = $sumBtk + $request->bbt_penilaian;
            $totalMnt = $request->tm + $request->sl + $request->asl + $request->asm;

            if($totalBtk <= 100){
                if ($totalMnt <= $request->responsi) {

                    $filLlo = LLo::where('rps_id', $request->rps_id)->where('id', $request->kode_llo)->first();


                    if($request->prak){

                        LLo::where('rps_id', $request->rps_id)->where('id', $request->kode_llo)->update([
                                'deskripsi_prak' => $request->des_llo,
                        ]);


                    }else{

                        LLo::where('rps_id', $request->rps_id)->where('id', $request->kode_llo)->update([
                            'deskripsi' => $request->des_llo,
                        ]);

                    }

                    DetailAgenda::where('id', $request->idDtl)->update([
                        'clo_id' => $request->clo_id,
                        'llo_id' => $filLlo->id,
                        'penilaian_id' => $request->btk_penilaian,
                        'bobot' => $request->bbt_penilaian,
                        'deskripsi_penilaian' => $request->des_penilaian,
                        'tm' => $request->tm,
                        'sl' => $request->sl,
                        'asl' => $request->asl,
                        'asm' => $request->asm,
                        'res_tutor' => $request->responsi,
                        'bljr_mandiri' => $request->belajarMandiri,
                        'praktikum' => $request->prak,
                        'capaian_llo' => $request->capai_llo,

                    ]);
                    return response()->json(['success' => 'Data berhasil Ditambahkan']);
                }else{
                    return response()->json(['errMnt' => 'Maaf total menit perkuliahan yang anda masukkan melebihi '.$request->responsi.' menit, Harap perbaiki data anda']);

                }
            }else{
                return response()->json(['errBbt' => 'Maaf Data bobot yang anda masukkan dijumlahkan melebihi 100% , Harap perbaiki data anda']);
            }
        }

        return response()->json(['error' => $validatedData->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgendaBelajar  $agendaBelajar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $rps)
    {
        $dtlAgd = DetailAgenda::find($id);

        if ($dtlAgd->agd_id) {

            $ifAgd = DetailAgenda::where('agd_id', $dtlAgd->agd_id)->count();
        }else{
            $ifAgd = 0;
        }

        if ($dtlAgd->llo_id) {

            $ifLlo = DetailAgenda::where('llo_id', $dtlAgd->llo_id)->count();
        }else{
            $ifLlo = 0;
        }


        $delAgdLlo = $dtlAgd;
        $dtlAgd->delete();

        if($ifAgd == 1){
            $agd = AgendaBelajar::find($delAgdLlo->agd_id);
            $agd->delete();
        }

        if ($ifLlo == 1) {
            $llo = LLo::find($delAgdLlo->llo_id);
            $llo->delete();
        }

        if ($dtlAgd) {
            Session::flash('message','Data berhasil dihapus.');
            Session::flash('alert-class','alert-success');
        }else{
            Session::flash('message','Data gagal dihapus.');
            Session::flash('alert-class','alert-danger');
        }
        return redirect()->route('agenda.index', $rps);
    }

    public function getSks(Request $request)
    {
        $mk = MataKuliah::where('id', $request->mk_id)->first();

        return $mk->sks;
    }

    public function listLlo(Request $request)
    {
        if ($request->week == '8' || $request->week == '16') {
            $condLlo = 'nullable';
            $conDes = 'nullable';
            $conCapai = 'nullable';

        }else{
            $condLlo = 'required|regex:/^LLO\d/';
            $conDes = 'required';
            $conCapai = 'required';
        }

        $validatedData =  Validator::make($request->all(), [
            'clo_id' => 'required',
            'kode_llo' => $condLlo,
            'des_llo' => $conDes,
            'capai_llo' => $conCapai,
            'btk_penilaian' => 'required_with:bbt_penilaian,des_penilaian',
            'bbt_penilaian' => 'required_with:btk_penilaian',
            'des_penilaian' => 'required_with:btk_penilaian',
            'tm' => 'required_without_all:sl,asl,asm,prak',
            'sl' => 'required_without_all:tm,asl,asm,prak',
            'asl' => 'required_without_all:tm,sl,asm,prak',
            'asm' => 'required_without_all:tm,sl,asl,prak',
            'responsi' => 'nullable',
            'belajarMandiri' => 'nullable',
            'prak' => 'required_if:isPrak,"1"',

        ]);


        $listLlo = [];

        $rps = Rps::find($request->rps_id);
        $mk = MataKuliah::where('id', $rps->kurlkl_id)->first();

        if ($validatedData->passes()) {

            $sumBtk = DetailAgenda::whereHas('agendaBelajar', function($query) use ($request){
                $query->where('rps_id', $request->rps_id);
            })->sum('bobot');

            $totalBtk = $sumBtk + $request->bbt_penilaian;
            $totalMnt = $request->tm + $request->sl + $request->asl + $request->asm;
            if($totalBtk <= 100){
                if ($totalMnt <= $mk->sks*60 && $request->responsi <= $mk->sks*60 && $request->belajarMandiri <= $mk->sks*60) {
                    if (session()->has('listLlo-'.$request->rps_id)) {

                        $dataLlo = session('listLlo-'.$request->rps_id);

                        foreach ($dataLlo as $item) {

                            array_push($listLlo, $item);

                        }

                        foreach ($request->status as $sts) {
                            if(session()->has('list'.$sts.'-'.$request->rps_id)){
                                $dataMateri = session('list'.$sts.'-'.$request->rps_id);
                                $request->request->add([$sts => $dataMateri]);

                            }

                        }
                        array_push($listLlo, $request->all());

                    }else{

                        foreach ($request->status as $sts) {
                            if(session()->has('list'.$sts.'-'.$request->rps_id)){
                                $dataMateri = session('list'.$sts.'-'.$request->rps_id);
                                $request->request->add([$sts => $dataMateri]);

                            }

                        }
                        array_push($listLlo, $request->all());

                    }

                    session(['listLlo-'.$request->rps_id => $listLlo]);
                    return response()->json(['success' => 'Data berhasil Ditambahkan', 'listLlo' => $listLlo]);

                }else{
                    return response()->json(['errMnt' => 'Maaf total menit perkuliahan yang anda masukkan melebihi '.($mk->sks*60).' menit, Harap perbaiki data anda']);
                }

            }else{
                return response()->json(['errBbt' => 'Maaf Data bobot yang anda masukkan dijumlahkan melebihi 100% , Harap perbaiki data anda']);
            }

        }

        return response()->json(['error' => $validatedData->errors()->all()]);
    }

    public function deleteLlo(Request $request)
    {
        $listLlo = session('listLlo-'.$request->rps_id);

        foreach ($listLlo as $key => $item) {
            if($item['idRow'] == $request->idRow){
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

    public function delAllMateri(Request $request)
    {
        session()->forget('list'.$request->status.'-'.$request->rps_id);

        return response()->json(['success' => 'Data berhasil Dihapus']);
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

        if($request->status == 'pustaka'){

            return DataTables::of($listMateri)
            ->addColumn('aksi', function ($data) {
            return '<button class="btn btn-danger delPustaka" data-pustaka="'.$data['id'].'"><i class="fas fa-trash"></i></button>';
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

        return DataTables::of($listMateri)
        ->addColumn('aksi', function ($data) use ($request) {
        return '<button class="btn btn-danger del'.$request->status.'" data-'.$request->status.'="'.$data[$request->status].'"><i class="fas fa-trash"></i></button>';
        })->rawColumns(['aksi'])
        ->make(true);

    }

    public function getMateriEdit(Request $request, $rps)
    {

        $dataMateri = MateriKuliah::where('dtl_agd_id', $request->detail_id)->where('status', $request->status)->get();

        return DataTables::of($dataMateri)
        ->addColumn('aksi', function ($data) use ($request) {
        return '<button class="btn btn-danger del'.$request->status.'" data-'.$data->status.'="'.$data->id.'"><i class="fas fa-trash"></i></button>';
        })->rawColumns(['aksi'])
        ->make(true);

    }

    public function addMateri(Request $request)
    {
        if ($request->status == 'pustaka') {
            $validatedData =  Validator::make($request->all(), [

                'detail_id' => 'required',
                'judul' => 'required',
                'bab' => 'required',
                'halaman' => 'required',
                'status' => 'required',

            ]);
        }else{
            $validatedData =  Validator::make($request->all(), [

                'detail_id' => 'required',
                'materi' => 'required',
                'status' => 'required',

            ]);
        }


        if ($validatedData->passes()) {

            if($request->status == 'kajian'){

                $addMateri = new MateriKuliah;
                $addMateri->dtl_agd_id = $request->detail_id;
                $addMateri->kajian = $request->materi;
                $addMateri->status = $request->status;
                $addMateri->save();

                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }else if($request->status == 'materi'){

                $addMateri = new MateriKuliah;
                $addMateri->dtl_agd_id = $request->detail_id;
                $addMateri->materi = $request->materi;
                $addMateri->status = $request->status;
                $addMateri->save();

                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }else if($request->status == 'pustaka'){

                $addMateri = new MateriKuliah;
                $addMateri->dtl_agd_id = $request->detail_id;
                $addMateri->jdl_ptk = $request->judul;
                $addMateri->bab_ptk = $request->bab;
                $addMateri->hal_ptk = $request->halaman;
                $addMateri->status = $request->status;
                $addMateri->save();

                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }else if($request->status == 'media'){

                $addMateri = new MateriKuliah;
                $addMateri->dtl_agd_id = $request->detail_id;
                $addMateri->media_bljr = $request->materi;
                $addMateri->status = $request->status;
                $addMateri->save();

                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }else if($request->status == 'metode'){

                $addMateri = new MateriKuliah;
                $addMateri->dtl_agd_id = $request->detail_id;
                $addMateri->mtd_bljr = $request->materi;
                $addMateri->status = $request->status;
                $addMateri->save();

                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }else if($request->status == 'pbm'){

                $addMateri = new MateriKuliah;
                $addMateri->dtl_agd_id = $request->detail_id;
                $addMateri->deskripsi_pbm = $request->materi;
                $addMateri->status = $request->status;
                $addMateri->save();

                return response()->json(['success' => 'Data berhasil Ditambahkan']);
            }

        }

        return response()->json(['error' => $validatedData->errors()->all()]);
    }

    public function removeMateri(Request $request)
    {
        $removeMateri = MateriKuliah::find($request->detail_id);
        $removeMateri->delete();
        return response()->json(['success' => 'Data berhasil Dihapus']);

    }

    public function getLlo(Request $request){
        // dd($request->all());
        $listLlo = session('listLlo-'.$request->rps_id);
        $llo = [];

        if($request->isDb){
            if (isset($request->isIndex)) {
                if ($request->isPrak == "1") {
                    $llo = Llo::select('deskripsi_prak')->where("id", $request->kode_llo)->where('rps_id', $request->rps_id)->pluck('deskripsi_prak');
                }else{
                    $llo = Llo::select('deskripsi')->where("id", $request->kode_llo)->where('rps_id', $request->rps_id)->pluck('deskripsi');
                }
            }else{

                if ($request->isPrak == "1") {
                    $llo = Llo::select('deskripsi_prak')->where("kode_llo", $request->kode_llo)->where('rps_id', $request->rps_id)->pluck('deskripsi_prak');
                }else{
                    $llo = Llo::select('deskripsi')->where("kode_llo", $request->kode_llo)->where('rps_id', $request->rps_id)->pluck('deskripsi');
                }
             }

        }else {
            if ($listLlo) {
                foreach ($listLlo as $l) {
                    if($l['kode_llo'] == $request->kode_llo && $l['isPrak'] == $request->isPrak){
                        $llo[] = $l['des_llo'];
                        break;
                    }
                }
            }
        }

        return $llo;
    }

    public function getLloSession(Request $request){

        $listLlo = session('listLlo-'.$request->rps_id);
        $llo = Llo::where('rps_id', $request->rps_id)->orderBy('id','asc')->pluck('kode_llo')->toArray();
        $uniqueLlo = array();
        if ($listLlo) {

            foreach ($listLlo as $lloSes) {

                if(in_array($lloSes['kode_llo'], $uniqueLlo) || in_array($lloSes['kode_llo'], $llo)){
                    continue;
                }
                array_push($uniqueLlo, $lloSes['kode_llo']);


            }
        }

        return $uniqueLlo;
    }

    public function cekPekan(Request $request){
        $cekPekan = AgendaBelajar::where('rps_id', $request->rps_id)->where('pekan', $request->week)->first();
        if($cekPekan){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error']);
        }
    }

    public function uptDate(Request $request){

        $this->validate($request, [
            'tanggal' => 'required'
        ]);
        $updateDate = AgendaBelajar::find($request->agd_id);
        $updateDate->tgl_nilai = $request->tanggal;
        $updateDate->save();

        Session::flash('message', 'Data berhasil diubah!');
        Session::flash('alert-class', 'alert-success');

        return back();
    }

    public function getDate(Request $request)
    {
        $date = AgendaBelajar::where('id', $request->id)->first();
        if($date){
            return response()->json(['status' => 'success', 'date' => $date->tgl_nilai]);
        }else{
            return response()->json(['status' => 'error']);
        }
    }
}
