<?php

namespace App\Http\Controllers;

use App\Models\BrilianDetail;
use App\Models\BrilianWeek;
use App\Models\Fakultas;
use App\Models\KaryawanDosen;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LaporanBrilianController extends Controller
{
    public function index()
    {
        // dd(request()->all());
        $filter = request()->all();
        $url = "https://mybrilian.dinamika.ac.id/undika/report/P3AI_-_klasemen_kelas_matakuliah.php?";


        $smt = Semester::where('fak_id', '41010')->first()->smt_aktif;
        $response = Http::get($url, [
            'semester' => $smt,
            'json' => true,
        ]);

        //data filters
        $fak = Fakultas::all();
        $prodi = Prodi::all();
        $kary = KaryawanDosen::all();
        $badges = [
            [

                'nama' => 'Bronze',
                'min' => 0,
                'max' => 2.49,

            ],
            [

                'nama' => 'Silver',
                'min' => 2.5,
                'max' => 2.99,
            ],
            [

                'nama' => 'Gold',
                'min' => 3,
                'max' => 3.49,
            ],
            [

                'nama' => 'Diamond',
                'min' => 3.5,
                'max' => 4,
            ],
        ];

        $decode = json_decode($response->getBody());
        $data = $decode->data;

        foreach ($data as $key => $value) {

            if ($value->skor_total >= 0 && $value->skor_total <= 2.49) {
                $data[$key]->badge = 'Bronze';
            } elseif ($value->skor_total >= 2.5 && $value->skor_total <= 2.99) {
                $data[$key]->badge = 'Silver';
            } elseif ($value->skor_total >= 3 && $value->skor_total <= 3.49) {
                $data[$key]->badge = 'Gold';
            } elseif ($value->skor_total >= 3.5 && $value->skor_total <= 4) {
                $data[$key]->badge = 'Diamond';
            }

        }

        //count when when badge include each data badge
        $cnBronze = collect($data)->where('badge', 'Bronze')->count();
        $cnSilver = collect($data)->where('badge', 'Silver')->count();
        $cnGold = collect($data)->where('badge', 'Gold')->count();
        $cnDiamond = collect($data)->where('badge', 'Diamond')->count();

        // percentage of each badge
        $prBronze = round($cnBronze / count($data) * 100);
        $prSilver = round($cnSilver / count($data) * 100);
        $prGold = round($cnGold / count($data) * 100);
        $prDiamond = round($cnDiamond / count($data) * 100);

        // divided the skor total by count each badge
        $avgBronze = round(collect($data)->where('badge', 'Bronze')->avg('skor_total'), 2);
        $avgSilver = round(collect($data)->where('badge', 'Silver')->avg('skor_total'), 2);
        $avgGold = round(collect($data)->where('badge', 'Gold')->avg('skor_total'), 2);
        $avgDiamond = round(collect($data)->where('badge', 'Diamond')->avg('skor_total'), 2);

        $rangBadge = [
            [
                'nama' => 'Bronze',
                'jumlah' => $cnBronze,
                'persen' => $prBronze,
                'avg' => $avgBronze,
            ],
            [
                'nama' => 'Silver',
                'jumlah' => $cnSilver,
                'persen' => $prSilver,
                'avg' => $avgSilver,
            ],
            [
                'nama' => 'Gold',
                'jumlah' => $cnGold,
                'persen' => $prGold,
                'avg' => $avgGold,
            ],
            [
                'nama' => 'Diamond',
                'jumlah' => $cnDiamond,
                'persen' => $prDiamond,
                'avg' => $avgDiamond,
            ],
        ];

        // dd($data);
        if (isset($filter['fakultas'])) {
            $filProdi = Prodi::whereIn('id_fakultas', $filter['fakultas'])->pluck('id')->toArray();
            $data = array_filter($data, function ($item) use ($filProdi) {
                $explode = explode(',', $item->prodi);
                foreach ($filProdi as $fil) {
                    foreach ($explode as $exp) {
                        if (stripos($exp, $fil) !== false) {
                            return true;
                        }
                    }
                }

            });
        }else if (isset($filter['prodi'])) {
            $data = array_filter($data, function ($item) use ($filter) {
                $explode = explode(',', $item->prodi);
                foreach ($filter['prodi'] as $fil) {
                    foreach ($explode as $exp) {
                        if (stripos($exp, $fil) !== false) {
                            return true;
                        }
                    }
                }

            });
        }else if (isset($filter['dosen'])) {
            $data = array_filter($data, function ($item) use ($filter) {
                return in_array($item->nik, $filter['dosen']);
            });
        } else if (isset($filter['badges'])) {
            $data = array_filter($data, function ($item) use ($filter) {

                foreach ($filter['badges'] as $badge) {
                    $explode = explode('-', $badge);

                    if($item->skor_total >= $explode[0] && $item->skor_total <= $explode[1]){

                        return true;
                    }
                }

            });
        }

        $indikator = $decode->indikator_penilaian;

        $week = BrilianWeek::where('semester', $smt)->get();
        $weekId = $week->pluck('id')->toArray();
        $dtlBri = BrilianDetail::whereIn('brilian_week_id', $weekId)->get();

        return view('laporan.brilian.index', compact('data','indikator', 'week', 'smt','dtlBri', 'fak', 'prodi', 'kary', 'rangBadge', 'badges'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $bWeek = BrilianWeek::create([
            'minggu_ke' => $request->minggu,
            'semester' => $request->semester,
        ]);

        foreach ($request->data['nik'] as $key => $value) {
            BrilianDetail::create([
                'brilian_week_id' => $bWeek->id,
                'nik' => $value,
                'kode_mk' => $request->data['kode_mk'][$key],
                'kelas' => $request->data['kelas'][$key],
                'prodi' => $request->data['prodi'][$key],
                'nilai' => $request->data['skor'][$key],
            ]);
        }

        Session::flash('message', 'Data berhasil ditambahkan');
        Session::flash('alert-class', 'alert-success');


        return back();

    }
}
