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
use PDF;
use iio\libmergepdf\Merger;

class LaporanBrilianController extends Controller
{

    public function index()
    {
        // dd(request()->all());
        $filter = request()->all();


        //data filters
        $fak = Fakultas::where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::all();

        // run function manipulateDataApi
        $manipulate = $this->manipulateDataApi();

        $data = $manipulate['data'];
        $indikator = $manipulate['indikator'];
        $smt = $manipulate['smt'];
        $dtlBri = $manipulate['dtlBri'];
        $prodi = $manipulate['prodi'];
        $rangBadge = $manipulate['rangBadge'];
        $badges = $manipulate['badges'];
        $rataFak = $manipulate['rataFak'];
        $rataProdi = $manipulate['rataProdi'];
        $pekan = $manipulate['pekan'];

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

        return view('laporan.brilian.index', compact('data','indikator', 'smt','dtlBri', 'fak', 'prodi', 'kary', 'rangBadge', 'badges', 'rataFak','rataProdi', 'pekan'));
    }

    public function store(Request $request)
    {

        $data = json_decode($request->data);

        $bWeek = BrilianWeek::create([
            'minggu_ke' => $request->minggu,
            'semester' => $request->semester,
        ]);

        foreach ($data as $value) {
            BrilianDetail::create([
                'brilian_week_id' => $bWeek->id,
                'nik' => $value->nik,
                'kode_mk' => $value->kode_mk,
                'kelas' => $value->kelas,
                'prodi' => $value->prodi,
                'nilai' => $value->skor_total,
            ]);
        }

        Session::flash('message', 'Data berhasil ditambahkan');
        Session::flash('alert-class', 'alert-success');


        return back();

    }

    public function manipulateDataApi(){

        $url = "https://mybrilian.dinamika.ac.id/undika/report/P3AI_-_klasemen_kelas_matakuliah.php?";

        $fak = Fakultas::where('sts_aktif', 'Y')->get();
        $arrFak = $fak->pluck('id')->toArray();
        $prodi = Prodi::whereIn('id_fakultas', $arrFak)->where('sts_aktif', 'Y')->get();

        $smt = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
        $response = Http::async()->get($url, [
            'semester' => $smt,
            'json' => true,
        ])->then(function ($res) {
            return $res->json();
        })->wait();


        dd($response);
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

        // $decode = json_decode($response->getBody());
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


        // rata-rata penggunaan brilian per fakultas

        $rataFak = [];
        $rataProdi = [];
        // get fakultas dari prodi
        foreach ($fak as $f) {
            $prodis = $prodi->where('id_fakultas', $f->id)->pluck('id')->toArray();
            $rataFak[$f->id] = [
                'nama' => $f->nama,
                'kategori' =>
                [
                    ['nama' =>  'Bronze',
                    'jumlah' => 0,
                    'persen' => 0,
                    'nilai' => 0,
                    ],
                    [
                        'nama' =>  'Silver',
                        'jumlah' => 0,
                        'persen' => 0,
                        'nilai' => 0,
                    ],
                    [
                        'nama' =>  'Gold',
                        'jumlah' => 0,
                        'persen' => 0,
                        'nilai' => 0,
                    ],
                    [
                        'nama' =>  'Diamond',
                        'jumlah' => 0,
                        'persen' => 0,
                        'nilai' => 0,
                    ],
                ],
                'nilai_akhir' => 0,

            ];

            // if data includes prodi
            foreach ($data as $key => $value) {
                $explode = array_unique(explode(',', $value->prodi));
                foreach ($prodis as $pro) {
                    foreach ($explode as $exp) {

                        if (stripos($exp, $pro) !== false) {
                            $dataCollect = collect($data)->where('prodi', $exp);
                            //count data kelas each fakultas
                            $rataFak[$f->id]['kategori'][0]['jumlah'] += $value->badge == 'Bronze' ? 1 : 0;
                            $rataFak[$f->id]['kategori'][1]['jumlah'] += $value->badge == 'Silver' ? 1 : 0;
                            $rataFak[$f->id]['kategori'][2]['jumlah'] += $value->badge == 'Gold' ? 1 : 0;
                            $rataFak[$f->id]['kategori'][3]['jumlah'] += $value->badge == 'Diamond' ? 1 : 0;


                            // average skor_total each fakultas
                            $rataFak[$f->id]['kategori'][0]['nilai'] += $rataFak[$f->id]['kategori'][0]['jumlah'] == 0 ? 0 : ($value->badge == 'Bronze' ? $value->skor_total : 0);

                            $rataFak[$f->id]['kategori'][1]['nilai'] += $rataFak[$f->id]['kategori'][1]['jumlah'] == 0 ? 0 : ($value->badge == 'Silver' ? $value->skor_total : 0);

                            $rataFak[$f->id]['kategori'][2]['nilai'] += $rataFak[$f->id]['kategori'][2]['jumlah'] == 0 ? 0 : ($value->badge == 'Gold' ? $value->skor_total : 0);

                            $rataFak[$f->id]['kategori'][3]['nilai'] += $rataFak[$f->id]['kategori'][3]['jumlah'] == 0 ? 0 : ($value->badge == 'Diamond' ? $value->skor_total : 0);


                        }

                    }

                }
            }

            $countAllJumlah = $rataFak[$f->id]['kategori'][0]['jumlah'] + $rataFak[$f->id]['kategori'][1]['jumlah'] + $rataFak[$f->id]['kategori'][2]['jumlah'] + $rataFak[$f->id]['kategori'][3]['jumlah'];
            //percentage of each fakultas
            $rataFak[$f->id]['kategori'][0]['persen'] = $countAllJumlah == 0 ? 0 : round($rataFak[$f->id]['kategori'][0]['jumlah'] / $countAllJumlah, 3) * 100;
            $rataFak[$f->id]['kategori'][1]['persen'] = $countAllJumlah == 0 ? 0 : round($rataFak[$f->id]['kategori'][1]['jumlah'] / $countAllJumlah, 3) * 100;
            $rataFak[$f->id]['kategori'][2]['persen'] = $countAllJumlah == 0 ? 0 : round($rataFak[$f->id]['kategori'][2]['jumlah'] / $countAllJumlah , 3) * 100;
            $rataFak[$f->id]['kategori'][3]['persen'] = $countAllJumlah == 0 ? 0 : round($rataFak[$f->id]['kategori'][3]['jumlah'] / $countAllJumlah , 3) * 100;

            //average skor_total of each fakultas
            $rataFak[$f->id]['kategori'][0]['nilai'] = $rataFak[$f->id]['kategori'][0]['jumlah'] == 0 ? 0 : round($rataFak[$f->id]['kategori'][0]['nilai'] / $rataFak[$f->id]['kategori'][0]['jumlah'], 2);

            $rataFak[$f->id]['kategori'][1]['nilai'] = $rataFak[$f->id]['kategori'][1]['jumlah'] == 0 ? 0 : round($rataFak[$f->id]['kategori'][1]['nilai'] / $rataFak[$f->id]['kategori'][1]['jumlah'], 2);

            $rataFak[$f->id]['kategori'][2]['nilai'] = $rataFak[$f->id]['kategori'][2]['jumlah'] == 0 ? 0 : round($rataFak[$f->id]['kategori'][2]['nilai'] / $rataFak[$f->id]['kategori'][2]['jumlah'], 2);

            $rataFak[$f->id]['kategori'][3]['nilai'] = $rataFak[$f->id]['kategori'][3]['jumlah'] == 0 ? 0 : round($rataFak[$f->id]['kategori'][3]['nilai'] / $rataFak[$f->id]['kategori'][3]['jumlah'], 2);

            // final result of each fakultas
            $rataFak[$f->id]['nilai_akhir'] = $countAllJumlah == 0 ? 0 : round((($rataFak[$f->id]['kategori'][0]['nilai'] * $rataFak[$f->id]['kategori'][0]['jumlah']) + ($rataFak[$f->id]['kategori'][1]['nilai'] * $rataFak[$f->id]['kategori'][1]['jumlah'] ) + ($rataFak[$f->id]['kategori'][2]['nilai'] * $rataFak[$f->id]['kategori'][2]['jumlah'] ) + ($rataFak[$f->id]['kategori'][3]['nilai'] * $rataFak[$f->id]['kategori'][3]['jumlah'] )) / $countAllJumlah, 2);




        }

        foreach($prodi as $p){
            $rataProdi[$p->id] = [
                'nama' => $p->nama,
                'kategori' => [
                    [
                        'nama' => 'Bronze',
                        'jumlah' => 0,
                        'nilai' => 0,
                        'persen' => 0
                    ],
                    [
                        'nama' => 'Silver',
                        'jumlah' => 0,
                        'nilai' => 0,
                        'persen' => 0
                    ],
                    [
                        'nama' => 'Gold',
                        'jumlah' => 0,
                        'nilai' => 0,
                        'persen' => 0
                    ],
                    [
                        'nama' => 'Diamond',
                        'jumlah' => 0,
                        'nilai' => 0,
                        'persen' => 0
                    ]
                ],
                'nilai_akhir' => 0
            ];

            foreach($data as $value){
                if(stripos($value->prodi, $p->id) !== false){
                    $rataProdi[$p->id]['kategori'][0]['jumlah'] += $value->badge == 'Bronze' ? 1 : 0;
                    $rataProdi[$p->id]['kategori'][1]['jumlah'] += $value->badge == 'Silver' ? 1 : 0;
                    $rataProdi[$p->id]['kategori'][2]['jumlah'] += $value->badge == 'Gold' ? 1 : 0;
                    $rataProdi[$p->id]['kategori'][3]['jumlah'] += $value->badge == 'Diamond' ? 1 : 0;

                    $rataProdi[$p->id]['kategori'][0]['nilai'] += $rataProdi[$p->id]['kategori'][0]['jumlah'] == 0 ? 0 : ($value->badge == 'Bronze' ? $value->skor_total : 0);

                    $rataProdi[$p->id]['kategori'][1]['nilai'] += $rataProdi[$p->id]['kategori'][1]['jumlah'] == 0 ? 0 : ($value->badge == 'Silver' ? $value->skor_total : 0);

                    $rataProdi[$p->id]['kategori'][2]['nilai'] += $rataProdi[$p->id]['kategori'][2]['jumlah'] == 0 ? 0 : ($value->badge == 'Gold' ? $value->skor_total : 0);

                    $rataProdi[$p->id]['kategori'][3]['nilai'] += $rataProdi[$p->id]['kategori'][3]['jumlah'] == 0 ? 0 : ($value->badge == 'Diamond' ? $value->skor_total : 0);

                }
            }

            $countAllJumlah = $rataProdi[$p->id]['kategori'][0]['jumlah'] + $rataProdi[$p->id]['kategori'][1]['jumlah'] + $rataProdi[$p->id]['kategori'][2]['jumlah'] + $rataProdi[$p->id]['kategori'][3]['jumlah'];

            //percentage of each prodi
            $rataProdi[$p->id]['kategori'][0]['persen'] = $countAllJumlah == 0 ? 0 : round($rataProdi[$p->id]['kategori'][0]['jumlah'] / $countAllJumlah * 100, 2);

            $rataProdi[$p->id]['kategori'][1]['persen'] = $countAllJumlah == 0 ? 0 : round($rataProdi[$p->id]['kategori'][1]['jumlah'] / $countAllJumlah * 100, 2);

            $rataProdi[$p->id]['kategori'][2]['persen'] = $countAllJumlah == 0 ? 0 : round($rataProdi[$p->id]['kategori'][2]['jumlah'] / $countAllJumlah * 100, 2);

            $rataProdi[$p->id]['kategori'][3]['persen'] = $countAllJumlah == 0 ? 0 : round($rataProdi[$p->id]['kategori'][3]['jumlah'] / $countAllJumlah * 100, 2);

            //average of each prodi
            $rataProdi[$p->id]['kategori'][0]['nilai'] = $rataProdi[$p->id]['kategori'][0]['jumlah'] == 0 ? 0 : round($rataProdi[$p->id]['kategori'][0]['nilai'] / $rataProdi[$p->id]['kategori'][0]['jumlah'], 2);

            $rataProdi[$p->id]['kategori'][1]['nilai'] = $rataProdi[$p->id]['kategori'][1]['jumlah'] == 0 ? 0 : round($rataProdi[$p->id]['kategori'][1]['nilai'] / $rataProdi[$p->id]['kategori'][1]['jumlah'], 2);

            $rataProdi[$p->id]['kategori'][2]['nilai'] = $rataProdi[$p->id]['kategori'][2]['jumlah'] == 0 ? 0 : round($rataProdi[$p->id]['kategori'][2]['nilai'] / $rataProdi[$p->id]['kategori'][2]['jumlah'], 2);

            $rataProdi[$p->id]['kategori'][3]['nilai'] = $rataProdi[$p->id]['kategori'][3]['jumlah'] == 0 ? 0 : round($rataProdi[$p->id]['kategori'][3]['nilai'] / $rataProdi[$p->id]['kategori'][3]['jumlah'], 2);

            //final result of each prodi
            $rataProdi[$p->id]['nilai_akhir'] = $countAllJumlah == 0 ? 0 : round((($rataProdi[$p->id]['kategori'][0]['nilai'] * $rataProdi[$p->id]['kategori'][0]['jumlah']) + ($rataProdi[$p->id]['kategori'][1]['nilai'] * $rataProdi[$p->id]['kategori'][1]['jumlah']) + ($rataProdi[$p->id]['kategori'][2]['nilai'] * $rataProdi[$p->id]['kategori'][2]['jumlah']) + ($rataProdi[$p->id]['kategori'][3]['nilai'] * $rataProdi[$p->id]['kategori'][3]['jumlah'])) /  $countAllJumlah, 2);


        }

        $indikator = $decode->indikator_penilaian;

        $pekan = BrilianWeek::where('semester', $smt)->get();
        $weekId = $pekan->pluck('id')->toArray();
        $dtlBri = BrilianDetail::whereIn('brilian_week_id', $weekId)->get();

        return ['data' => $data, 'indikator' => $indikator, 'smt' => $smt, 'prodi' => $prodi, 'rangBadge' => $rangBadge, 'badges' => $badges, 'rataFak' => $rataFak, 'rataProdi' => $rataProdi, 'dtlBri' => $dtlBri, 'pekan' => $pekan ];
    }

    public function exportPdf()
    {
        $manipulate = $this->manipulateDataApi();

        $data = $manipulate['data'];
        $rangBadge = $manipulate['rangBadge'];
        $rataFak = $manipulate['rataFak'];
        $rataProdi = $manipulate['rataProdi'];
        $indikator = $manipulate['indikator'];
        $pekan = $manipulate['pekan'];
        $dtlBri = $manipulate['dtlBri'];

        if (request()->has('prodi')) {
            $filProdi = Prodi::whereIn('id', request('prodi'))->get();
        } else {
            $filProdi = null;
        }

        $m = new Merger();

        $pdf = PDF::loadView('laporan.brilian.export-pdf', ['rangBadge' => $rangBadge,
        'rataFak' => $rataFak,
        'rataProdi' => $rataProdi,

        ]);

        $m->addRaw($pdf->output());

        $pdf2 = PDF::loadView('laporan.brilian.export-pdf-2', ['data' => $data,
        'indikator' => $indikator,
        'week' => $pekan,
        'dtlBri' => $dtlBri,
        'prodi' => $filProdi,
        ])->setPaper('a4', 'landscape');

        $m->addRaw($pdf2->output());

        $pdfMerge = $m->merge();

        return response()->streamDownload(function () use ($pdfMerge) {
            echo $pdfMerge;
        }, 'laporan_penggunaan_brilian_'.date('Y-m-d_H-i-s').'.pdf');
    }
}
