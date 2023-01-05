<?php

namespace App\Http\Controllers;

use App\Mail\DosenPenyusun;
use App\Models\AgendaBelajar;
use App\Models\DetailAgenda;
use App\Models\Fakultas;
use App\Models\InstrumenNilai;
use App\Models\JadwalKuliah;
use App\Models\KaryawanDosen;
use App\Models\MailStaf;
use App\Models\MataKuliah;
use App\Models\MateriKuliah;
use App\Models\Prodi;
use App\Models\Rps;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RpsController extends Controller
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
        // Data Filters
        $fak = Fakultas::all();
        $prodi = Prodi::where('sts_aktif', 'Y')->orderBy('id', 'asc')->get();

        $role = auth()->user()->role;
        $nik = auth()->user()->nik;
        $dosens = KaryawanDosen::with('emailStaf')->where('fakul_id', '<>', null)->where('kary_type', 'like', '%TD%')->get();

        $mailStaf = MailStaf::whereIn('nik', $dosens->pluck('nik')->toArray())->get();
        $smt = $this->semester;
        if ($role == 'dosen') {

            $rps = Rps::where('penyusun', $nik)->latest()->fakultas()->prodi()->name()->status()->paginate(6)->withQueryString();
        }else if($role == 'dekan'){

            $fakDekan = $fak->where('mngr_id', $nik)->first();
            $prodi = $prodi->where('id_fakultas', $fakDekan->id);
            $prodiDekan = $prodi->pluck('id')->toArray();
            $mk = MataKuliah::whereIn('fakul_id', $prodiDekan)->pluck('id')->toArray();
            $rps = Rps::whereIn('kurlkl_id', $mk)->latest()->fakultas()->prodi()->name()->status()->penyusun()->file()->semester()->paginate(6)->withQueryString();
        }else if ($role == 'kaprodi') {
            $prodiKaprodi = $prodi->where('mngr_id', $nik)->first();
            $mk = MataKuliah::where('fakul_id', $prodiKaprodi->id)->pluck('id')->toArray();
            $rps = Rps::whereIn('kurlkl_id', $mk)->latest()->fakultas()->prodi()->name()->status()->penyusun()->file()->semester()->paginate(6)->withQueryString();
        }else{
            $rps = Rps::latest()->fakultas()->prodi()->name()->status()->penyusun()->file()->semester()->paginate(6)->withQueryString();
        }

        return view('rps.index', compact('rps','fak','prodi', 'dosens', 'smt', 'mailStaf'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $prodi = Prodi::where('mngr_id', $user->nik)->orderBy('id', 'asc')->first();
        $jdw = MataKuliah::where('fakul_id', $prodi->id)->distinct('id')->get();
        $filMk = [];

        $smt = $this->semester;
        foreach ($jdw as $i) {

            $findRps = Rps::where('kurlkl_id', $i->id)->first();

            if(!$findRps){
                $uniqueMk = current(array_filter($filMk, function($item) use ($i){
                    return $item['klkl_id'] == $i->id;
                }));

                if (!$uniqueMk) {
                    $filMk[] = $i;
                }
            }

        }
        $mk = $filMk;
        $dosens = KaryawanDosen::where('fakul_id', $prodi->id)->where('kary_type', 'like', '%TD%')->get();

        return view('rps.create', compact('mk','dosens', 'smt'));
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
            'rumpun_mk' => 'required',
            'ketua_rumpun' => 'required',
            'mklist' => 'required',
        ]);

        // dd($request->all());

        foreach ($request->mklist as $i) {


            $mk = MataKuliah::where('id',$i)->first();
            $findRps = Rps::where('kurlkl_id', $i)->where('semester',$request->semester)->first();
            $smt = $this->semester;

            if ($findRps) {
                continue;
            }else{
                $rps = new Rps;
                $rps->kurlkl_id = $i;
                $rps->nik = $request->ketua_rumpun;
                $rps->nama_mk = $mk->nama;
                $rps->rumpun_mk = $request->rumpun_mk;
                $rps->semester = $smt;
                $rps->save();

            }

            Session::flash('message', 'Data berhasil ditambahkan!');
            Session::flash('alert-class', 'alert-success');

        }


        return redirect()->route('rps.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rps  $rps
     * @return \Illuminate\Http\Response
     */
    public function show(Rps $rps)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rps  $rps
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $rps = Rps::with('karyawan','dosenPenyusun')->findOrFail($request->get('id'));
        return response()->json($rps);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rps  $rps
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rps $rps)
    {

        if (isset($request->rps_id)) {

            $validation = $request->validate([
                'rumpun_mk' => 'required',
                'ketua_rumpun' => 'required',
                'penyusun' => 'required',
                'emailPenyusun' => 'required',
            ]);

            $updateRps = Rps::where('id', $request->rps_id)->update(
                [
                    'rumpun_mk' => $request->rumpun_mk,
                    'nik' => $request->ketua_rumpun,
                    'penyusun' => $request->penyusun,
                    'email_penyusun' => $request->emailPenyusun,

                ]
            );

            if ($updateRps) {
                Session::flash('message', 'Data berhasil diubah!');
                Session::flash('alert-class', 'alert-success');
            } else {
                Session::flash('message', 'Data gagal diubah!');
                Session::flash('alert-class', 'alert-danger');
            }
            return redirect()->route('rps.index');

        }else {

            $validation = $request->validate([
                'deskripsi_mk' => 'required',
            ]);

            $updateRps = Rps::where('id', $rps->id)
                ->update(['deskripsi_mk' => $request->deskripsi_mk]);

            if ($updateRps) {
                Session::flash('message','Data berhasil diubah.');
                Session::flash('alert-class','alert-success');
            }else{
                Session::flash('message','Data gagal diubah.');
                Session::flash('alert-class','alert-danger');
            }
            return redirect()->route('clo.index', $rps->id);
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rps  $rps
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rps = Rps::destroy($id);

        if ($rps) {
            Session::flash('message', 'File Rps berhasil dihapus!');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'File Rps gagal dihapus!');
            Session::flash('alert-class', 'alert-danger');
        }
        return back();
    }

    public function rangkuman(Rps $rps)
    {

        $dataRps = Rps::where('id', $rps->id)->get();
        $smt = $this->semester;
        $kultot = DetailAgenda::whereHas('agendaBelajar', function($q) use ($rps){
            $q->where('rps_id', $rps->id);
        })
        ->select(DB::raw('SUM(tm) as tm, SUM(sl) as sl, SUM(asl) as asl, SUM(asm) as asm, SUM(praktikum) as prak'))
        ->get();

        $med = MateriKuliah::whereHas('detailAgenda', function($q) use ($rps){
            $q->whereHas('agendaBelajar', function($q) use ($rps){
                $q->where('rps_id', $rps->id);
            });
        })->select('media_bljr')->where('status', 'media')->distinct()->get();

        $pus = MateriKuliah::whereHas('detailAgenda', function($q) use ($rps){
            $q->whereHas('agendaBelajar', function($q) use ($rps){
                $q->where('rps_id', $rps->id);
            });
        })->select('jdl_ptk', 'bab_ptk', 'hal_ptk')->where('status', 'pustaka')->distinct()->get();

        $pbm = MateriKuliah::whereHas('detailAgenda', function($q) use ($rps){
            $q->whereHas('agendaBelajar', function($q) use ($rps){
                $q->where('rps_id', $rps->id);
            });
        })->select('deskripsi_pbm')->where('status', 'pbm')->distinct()->get();

        return view('rps.rangkuman', compact('dataRps','rps','kultot','med','pus','pbm', 'smt'));
    }

    public function saveFileRps(Request $request)
    {
        $validatedData =  Validator::make($request->all(), [
            'rps' => 'required|mimes:pdf|max:51200',
        ]);

        if ($validatedData->passes()) {
            $findRps = Rps::findOrFail($request->get('mrps_id'));

            if ($findRps->file_rps) {
                Storage::delete($findRps->file_rps);

                $rps = $findRps->update([
                    'file_rps' => $request->file('rps')->store('rps-file'),
                ]);

            }else{

                $rps = Rps::findOrFail($request->get('mrps_id'))->update([
                    'file_rps' => $request->file('rps')->store('rps-file'),
                ]);
            }

            if ($rps) {
                Session::flash('message', 'File Rps berhasil disimpan!');
                Session::flash('alert-class', 'alert-success');
            }else {
                Session::flash('message', 'File Rps gagal diupload!');
                Session::flash('alert-class', 'alert-danger');
            }

            return redirect()->route('rps.index');
        }

        return redirect()->back()->withErrors($validatedData->errors());
    }

    public function transferAgenda(Request $request)
    {
        $rps = Rps::findOrFail($request->get('rps_id'));
        $sumBobot = DetailAgenda::whereHas('agendaBelajar', function($q) use ($rps){
            $q->where('rps_id', $rps->id);
        })->sum('bobot');

        if ($sumBobot == 100) {
            $rps->update([
                'is_done' => '1',
            ]);

            return json_encode(['status' => 'success', 'message' => 'Agenda Pembelajaran selesai!']);
        }else{
            return json_encode(['status' => 'error', 'message' => 'Bobot Penilaian belum mencapai 100%, silahkan cek kembali!']);
        }

    }

    public function updatePenyusun(Request $request)
    {
        $rps = Rps::findOrFail($request->get('rps_id'));
        $dosen = KaryawanDosen::whereNik($request->get('penyusun'))->first();
        $update = $rps->update([
            'penyusun' => $request->get('penyusun'),
            'email_penyusun' => $request->get('emailPenyusun'),
        ]);

        Mail::to($request->get('emailPenyusun'))->send(new DosenPenyusun($rps,$dosen));

        if ($update) {
            Session::flash('message', 'Penyusun berhasil diubah!');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Penyusun gagal diubah!');
            Session::flash('alert-class', 'alert-danger');
        }
        return back();

    }
}
