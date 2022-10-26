<?php

namespace App\Http\Controllers;

use App\Models\AngketTrans;
use App\Models\Bap;
use App\Models\InstrumenNilai;
use App\Models\JadwalKuliah;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MingguKuliah;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function apiwithoutKey()
    {

        $url = "https://mybrilian.dinamika.ac.id/undika/report/P3AI_-_klasemen_kelas_matakuliah.php?";


        $response = Http::get($url, [
            'semester' => '202',
            'json' => true,
        ]);


        $responseBody = json_decode($response->getBody());

        dd($responseBody->data);
    }

    public function cekData(){
        // $jdwkul = JadwalKuliah::pluck('kary_nik')->toArray()->unique();
        $mk = InstrumenNilai::where('semester', '212')->get();

        //json
        $data = [
            'data' => $mk,
            'count' => $mk->count(),
        ];

        return response()->json($data);
    }
}
