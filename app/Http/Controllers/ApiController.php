<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function apiwithoutKey()
    {

        $url = "https://mybrilian.dinamika.ac.id/undika/report/P3AI_-_klasemen_kelas_matakuliah.php?";


        $response = Http::get($url, [
            'semester' => '211',
            'json' => true,
        ]);


        $responseBody = json_decode($response->getBody());

        dd($responseBody);
    }
}
