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
    private $semester;

    public function __construct()
    {
        $this->semester = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
    }

    public function index()
    {
        // dd(request()->all());
        $filter = request()->all();


        //data filters
        $fak = Fakultas::where('sts_aktif', 'Y')->get();
        $kary = KaryawanDosen::all();


        $data = $this->manipulateDataApi()['data'];
        $indikator = $this->manipulateDataApi()['indikator'];
        $smt = $this->semester;
        $prodi = $this->manipulateDataApi()['prodi'];
        $rangBadge = $this->manipulateDataApi()['rangBadge'];
        $badges = $this->manipulateDataApi()['badges'];
        $rataFak = $this->manipulateDataApi()['rataFak'];
        $rataProdi = $this->manipulateDataApi()['rataProdi'];


        if (isset($filter['fakultas'])) {
            $filProdi = Prodi::whereIn('id_fakultas', $filter['fakultas'])->pluck('id')->toArray();
            $data = $data->filter(function ($item) use ($filProdi) {
                $explode = explode(',', $item['prodi']);
                foreach ($filProdi as $fil) {
                    foreach ($explode as $exp) {
                        if (stripos($exp, $fil) !== false) {
                            return true;
                        }
                    }
                }

            });
        }
        if (isset($filter['prodi'])) {
            $data = $data->filter(function ($item) use ($filter) {
                $explode = explode(',', $item['prodi']);
                foreach ($filter['prodi'] as $fil) {
                    foreach ($explode as $exp) {
                        if (stripos($exp, $fil) !== false) {
                            return true;
                        }
                    }
                }

            });
        }
        if (isset($filter['dosen'])) {
            $data = $data->filter(function ($item) use ($filter) {
                return in_array($item['nik'], $filter['dosen']);
            });
        }
        if (isset($filter['badges'])) {
            $data = $data->filter(function ($item) use ($filter) {

                foreach ($filter['badges'] as $badge) {
                    $explode = explode('-', $badge);

                    if($item['skor_total'] >= $explode[0] && $item['skor_total'] <= $explode[1]){

                        return true;
                    }
                }

            });
        }


        $pekan = BrilianWeek::where('semester', $smt)->with('brilianDetails')->get();


        return view('laporan.brilian.index', compact('data','indikator', 'smt', 'fak', 'prodi', 'kary', 'rangBadge', 'badges', 'rataFak','rataProdi', 'pekan'));
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

        $smt = $this->semester;
        //get api data

        $response = Http::async()->get($url, [
            'semester' => $smt,
            'json' => true,
        ])->then(function ($res) {
            return $res->json();
        })->wait();

        $fak = Fakultas::where('sts_aktif', 'Y')->with('prodis')->get();
        $prodi = Prodi::whereIn('id_fakultas', $fak->pluck('id')->toArray())->get();

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

        if($response){

            $data = $response['data'];

            $data = collect($data)->map(function ($data){
                $data['badge'] = $data['skor_total'] >= 0 && $data['skor_total'] <= 2.49 ? 'Bronze' : ($data['skor_total'] >= 2.5 && $data['skor_total'] <= 2.99 ? 'Silver' : ($data['skor_total'] >= 3 && $data['skor_total'] <= 3.49 ? 'Gold' : ($data['skor_total'] >= 3.5 && $data['skor_total'] <= 4 ? 'Diamond' : '')));

                return $data;
            });

            //count when when badge include each data badge
            $cnBronze = $data->where('badge', 'Bronze')->count();
            $cnSilver = $data->where('badge', 'Silver')->count();
            $cnGold = $data->where('badge', 'Gold')->count();
            $cnDiamond = $data->where('badge', 'Diamond')->count();

            // percentage of each badge
            $prBronze = round($cnBronze / count($data) * 100);
            $prSilver = round($cnSilver / count($data) * 100);
            $prGold = round($cnGold / count($data) * 100);
            $prDiamond = round($cnDiamond / count($data) * 100);

            // divided the skor total by count each badge
            $avgBronze = round($data->where('badge', 'Bronze')->avg('skor_total'), 2);
            $avgSilver = round($data->where('badge', 'Silver')->avg('skor_total'), 2);
            $avgGold = round($data->where('badge', 'Gold')->avg('skor_total'), 2);
            $avgDiamond = round($data->where('badge', 'Diamond')->avg('skor_total'), 2);

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

            $rataFak = [];
            $rataProdi = [];
            // get fakultas dari prodi
            foreach ($fak as $f) {
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
                foreach ($f->prodis as $p) {
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
                    foreach ($data as $key => $value) {
                    $explode = array_unique(explode(',', $value['prodi']));

                        if(stripos($value['prodi'], $p->id) !== false){
                            $rataProdi[$p->id]['kategori'][0]['jumlah'] += $value['badge'] == 'Bronze' ? 1 : 0;
                            $rataProdi[$p->id]['kategori'][1]['jumlah'] += $value['badge'] == 'Silver' ? 1 : 0;
                            $rataProdi[$p->id]['kategori'][2]['jumlah'] += $value['badge'] == 'Gold' ? 1 : 0;
                            $rataProdi[$p->id]['kategori'][3]['jumlah'] += $value['badge'] == 'Diamond' ? 1 : 0;

                            $rataProdi[$p->id]['kategori'][0]['nilai'] += $rataProdi[$p->id]['kategori'][0]['jumlah'] == 0 ? 0 : ($value['badge'] == 'Bronze' ? $value['skor_total'] : 0);

                            $rataProdi[$p->id]['kategori'][1]['nilai'] += $rataProdi[$p->id]['kategori'][1]['jumlah'] == 0 ? 0 : ($value['badge'] == 'Silver' ? $value['skor_total'] : 0);

                            $rataProdi[$p->id]['kategori'][2]['nilai'] += $rataProdi[$p->id]['kategori'][2]['jumlah'] == 0 ? 0 : ($value['badge'] == 'Gold' ? $value['skor_total'] : 0);

                            $rataProdi[$p->id]['kategori'][3]['nilai'] += $rataProdi[$p->id]['kategori'][3]['jumlah'] == 0 ? 0 : ($value['badge'] == 'Diamond' ? $value['skor_total'] : 0);

                        }

                        foreach ($explode as $exp) {

                            if (stripos($exp, $p->id) !== false) {

                                // count jumlah badge each fakultas
                                $rataFak[$f->id]['kategori'][0]['jumlah'] += $value['badge'] == 'Bronze' ? 1 : 0;
                                $rataFak[$f->id]['kategori'][1]['jumlah'] += $value['badge'] == 'Silver' ? 1 : 0;
                                $rataFak[$f->id]['kategori'][2]['jumlah'] += $value['badge'] == 'Gold' ? 1 : 0;
                                $rataFak[$f->id]['kategori'][3]['jumlah'] += $value['badge'] == 'Diamond' ? 1 : 0;


                                // average skor_total each fakultas
                                $rataFak[$f->id]['kategori'][0]['nilai'] += $rataFak[$f->id]['kategori'][0]['jumlah'] == 0 ? 0 : ($value['badge'] == 'Bronze' ? $value['skor_total'] : 0);

                                $rataFak[$f->id]['kategori'][1]['nilai'] += $rataFak[$f->id]['kategori'][1]['jumlah'] == 0 ? 0 : ($value['badge'] == 'Silver' ? $value['skor_total'] : 0);

                                $rataFak[$f->id]['kategori'][2]['nilai'] += $rataFak[$f->id]['kategori'][2]['jumlah'] == 0 ? 0 : ($value['badge'] == 'Gold' ? $value['skor_total'] : 0);

                                $rataFak[$f->id]['kategori'][3]['nilai'] += $rataFak[$f->id]['kategori'][3]['jumlah'] == 0 ? 0 : ($value['badge'] == 'Diamond' ? $value['skor_total'] : 0);


                            }

                        }
                    }

                    // Prodi
                    $countAllJumlah = $rataProdi[$p->id]['kategori'][0]['jumlah'] + $rataProdi[$p->id]['kategori'][1]['jumlah'] + $rataProdi[$p->id]['kategori'][2]['jumlah'] + $rataProdi[$p->id]['kategori'][3]['jumlah'];

                    //percentage of each prodi
                    $rataProdi[$p->id]['kategori'][0]['persen'] = $countAllJumlah == 0 ? 0 : round($rataProdi[$p->id]['kategori'][0]['jumlah'] / $countAllJumlah, 3) * 100;

                    $rataProdi[$p->id]['kategori'][1]['persen'] = $countAllJumlah == 0 ? 0 : round($rataProdi[$p->id]['kategori'][1]['jumlah'] / $countAllJumlah, 3) * 100;

                    $rataProdi[$p->id]['kategori'][2]['persen'] = $countAllJumlah == 0 ? 0 : round($rataProdi[$p->id]['kategori'][2]['jumlah'] / $countAllJumlah, 3) * 100;

                    $rataProdi[$p->id]['kategori'][3]['persen'] = $countAllJumlah == 0 ? 0 : round($rataProdi[$p->id]['kategori'][3]['jumlah'] / $countAllJumlah, 3) * 100;

                    //average of each prodi
                    $rataProdi[$p->id]['kategori'][0]['nilai'] = $rataProdi[$p->id]['kategori'][0]['jumlah'] == 0 ? 0 : round($rataProdi[$p->id]['kategori'][0]['nilai'] / $rataProdi[$p->id]['kategori'][0]['jumlah'], 2);

                    $rataProdi[$p->id]['kategori'][1]['nilai'] = $rataProdi[$p->id]['kategori'][1]['jumlah'] == 0 ? 0 : round($rataProdi[$p->id]['kategori'][1]['nilai'] / $rataProdi[$p->id]['kategori'][1]['jumlah'], 2);

                    $rataProdi[$p->id]['kategori'][2]['nilai'] = $rataProdi[$p->id]['kategori'][2]['jumlah'] == 0 ? 0 : round($rataProdi[$p->id]['kategori'][2]['nilai'] / $rataProdi[$p->id]['kategori'][2]['jumlah'], 2);

                    $rataProdi[$p->id]['kategori'][3]['nilai'] = $rataProdi[$p->id]['kategori'][3]['jumlah'] == 0 ? 0 : round($rataProdi[$p->id]['kategori'][3]['nilai'] / $rataProdi[$p->id]['kategori'][3]['jumlah'], 2);

                    //final result of each prodi
                    $rataProdi[$p->id]['nilai_akhir'] = $countAllJumlah == 0 ? 0 : round((($rataProdi[$p->id]['kategori'][0]['nilai'] * $rataProdi[$p->id]['kategori'][0]['jumlah']) + ($rataProdi[$p->id]['kategori'][1]['nilai'] * $rataProdi[$p->id]['kategori'][1]['jumlah']) + ($rataProdi[$p->id]['kategori'][2]['nilai'] * $rataProdi[$p->id]['kategori'][2]['jumlah']) + ($rataProdi[$p->id]['kategori'][3]['nilai'] * $rataProdi[$p->id]['kategori'][3]['jumlah'])) /  $countAllJumlah, 2);

                }


                // Fakultas
                $countAllJumlah = $rataFak[$f->id]['kategori'][0]['jumlah'] + $rataFak[$f->id]['kategori'][1]['jumlah'] + $rataFak[$f->id]['kategori'][2]['jumlah'] + $rataFak[$f->id]['kategori'][3]['jumlah'];


                $rataFak[$f->id]['kategori'][0]['persen'] = $countAllJumlah == 0 ? 0 : round($rataFak[$f->id]['kategori'][0]['jumlah'] / $countAllJumlah, 3) * 100;
                $rataFak[$f->id]['kategori'][1]['persen'] = $countAllJumlah == 0 ? 0 : round($rataFak[$f->id]['kategori'][1]['jumlah'] / $countAllJumlah, 3) * 100;
                $rataFak[$f->id]['kategori'][2]['persen'] = $countAllJumlah == 0 ? 0 : round($rataFak[$f->id]['kategori'][2]['jumlah'] / $countAllJumlah , 3) * 100;
                $rataFak[$f->id]['kategori'][3]['persen'] = $countAllJumlah == 0 ? 0 : round($rataFak[$f->id]['kategori'][3]['jumlah'] / $countAllJumlah, 3) * 100;

                //average skor_total of each fakultas
                $rataFak[$f->id]['kategori'][0]['nilai'] = $rataFak[$f->id]['kategori'][0]['jumlah'] == 0 ? 0 : round($rataFak[$f->id]['kategori'][0]['nilai'] / $rataFak[$f->id]['kategori'][0]['jumlah'], 2);

                $rataFak[$f->id]['kategori'][1]['nilai'] = $rataFak[$f->id]['kategori'][1]['jumlah'] == 0 ? 0 : round($rataFak[$f->id]['kategori'][1]['nilai'] / $rataFak[$f->id]['kategori'][1]['jumlah'], 2);

                $rataFak[$f->id]['kategori'][2]['nilai'] = $rataFak[$f->id]['kategori'][2]['jumlah'] == 0 ? 0 : round($rataFak[$f->id]['kategori'][2]['nilai'] / $rataFak[$f->id]['kategori'][2]['jumlah'], 2);

                $rataFak[$f->id]['kategori'][3]['nilai'] = $rataFak[$f->id]['kategori'][3]['jumlah'] == 0 ? 0 : round($rataFak[$f->id]['kategori'][3]['nilai'] / $rataFak[$f->id]['kategori'][3]['jumlah'], 2);

                // final result of each fakultas
                $rataFak[$f->id]['nilai_akhir'] = $countAllJumlah == 0 ? 0 : round((($rataFak[$f->id]['kategori'][0]['nilai'] * $rataFak[$f->id]['kategori'][0]['jumlah']) + ($rataFak[$f->id]['kategori'][1]['nilai'] * $rataFak[$f->id]['kategori'][1]['jumlah'] ) + ($rataFak[$f->id]['kategori'][2]['nilai'] * $rataFak[$f->id]['kategori'][2]['jumlah'] ) + ($rataFak[$f->id]['kategori'][3]['nilai'] * $rataFak[$f->id]['kategori'][3]['jumlah'] )) / $countAllJumlah, 2);

            }

            $indikator = $response['indikator_penilaian'];
        }else{
            $data = [];
            $indikator = [];
            $rangBadge = [];
            $rataFak = [];
            $rataProdi = [];
        }

        return ['data' => $data, 'indikator' => $indikator, 'smt' => $smt, 'prodi' => $prodi, 'rangBadge' => $rangBadge, 'badges' => $badges, 'rataFak' => $rataFak, 'rataProdi' => $rataProdi];

    }

    public function exportPdf()
    {
        $manipulate = $this->manipulateDataApi();

        $data = $manipulate['data'];
        $rangBadge = $manipulate['rangBadge'];
        $rataFak = $manipulate['rataFak'];
        $rataProdi = $manipulate['rataProdi'];
        $indikator = $manipulate['indikator'];
        $smt = $manipulate['smt'];

        $pekan = BrilianWeek::where('semester', $smt)->with('brilianDetails')->get();

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
        'prodi' => $filProdi,
        ])->setPaper('a4', 'landscape');

        $m->addRaw($pdf2->output());

        $pdfMerge = $m->merge();

        return response()->streamDownload(function () use ($pdfMerge) {
            echo $pdfMerge;
        }, 'laporan_penggunaan_brilian_'.date('Y-m-d_H-i-s').'.pdf');
    }


}
