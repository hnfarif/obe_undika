<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class LaporanBrilianController extends Controller
{
    public function index()
    {
        $url = "https://mybrilian.dinamika.ac.id/undika/report/P3AI_-_klasemen_kelas_matakuliah.php?";


        $smt = Semester::where('fak_id', '41010')->first();
        $response = Http::get($url, [
            'semester' => $smt->smt_aktif,
            'json' => true,
        ]);


        $decode = json_decode($response->getBody());
        $data = $decode->data;
        $indikator = $decode->indikator_penilaian;


        return view('laporan.brilian.index', compact('data','indikator'));
    }
}
