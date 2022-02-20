<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/peoplo', function () {
//     return view('kelolapeoplo.index');
// });

Route::prefix('kelola')->group(function () {
    Route::get('/peo', function () {
        return view('kelolapeoplo.kelolapeo');
    })->name('peoplo.peo');
    Route::get('/plo', function () {
        return view('kelolapeoplo.kelolaplo');
    })->name('peoplo.plo');
    Route::get('/map', function () {
        return view('kelolapeoplo.mapping');
    })->name('peoplo.mapping');
});

Route::prefix('rps')->group(function (){

    Route::get('/', function (){

        return view('rps.index');
    })->name('kelola.rps');

    Route::get('/wbm', function (){

        return view('rps.kelolawbm');
    })->name('kelola.wbm');


    Route::get('/plottingmk', function (){

        return view('rps.plottingmk');
    })->name('kelola.rps.plottingmk');

    Route::get('/plottingdosen', function (){

        return view('rps.plottingdsn');
    })->name('kelola.rps.plottingdsn');

    Route::get('/clo', function (){

        return view('rps.clo.index');
    })->name('kelola.clo');

    Route::get('/clo/create', function (){

        return view('rps.clo.create');
    })->name('kelola.clo.create');

    Route::get('/penilaian', function (){

        return view('rps.penilaian');
    })->name('kelola.penilaian');

    Route::get('/agenda', function (){

        return view('rps.agenda.index');
    })->name('kelola.agenda');

    Route::get('/agenda/create', function (){

        return view('rps.agenda.create');
    })->name('kelola.agenda.create');
});

Route::prefix('instrumen-nilai')->group(function (){


    Route::get('/', function (){

        return view('instrumen-nilai.index');
    })->name('kelola.instrumen-nilai');
    Route::get('/mhs', function (){

        return view('instrumen-nilai.nilaimhs');
    })->name('kelola.nilai-mhs');
});

Route::prefix('plotting')->group(function(){

    Route::get('/', function (){

        return view('plotting-gpm.index');
    })->name('kelola.plotting');

});

Route::get('/data-penilaian', function(Request $request){

    $data = [
        [
            'id' => 1,
        'kode_clo' => 'CLO-01',
        'pendapat' => '3',
        'mandiri' => '3',
        'kelompok' => '3',
        'presentasi' => '3',
        'uts' => '3',
        'uas' => '3',
        'total_bobot' => '3',
        'target_lls' => '100',
        'nilai_min' => '60',
        ],
        [
            'id' => 2,
        'kode_clo' => 'CLO-02',
        'pendapat' => '3',
        'mandiri' => '3',
        'kelompok' => '3',
        'presentasi' => '3',
        'uts' => '3',
        'uas' => '3',
        'total_bobot' => '3',
        'target_lls' => '100 ',
        'nilai_min' => '60 ',
        ]
    ];

    $output = [
        "draw" => $request->get('draw'),
        "recordsTotal" => count($data),
        "recordsFiltered" => count($data),
        "data" => $data
    ];
    return response()->json($output);
})->name('data-penilaian');

Route::get('/data-nilai-mhs', function(Request $request){

    $data = [
        [
            'id' => 1,
        'kode_clo' => '16410100038',
        'pendapat' => 'Satya Agatha Fargaf',
        'mandiri' => '3',
        'kelompok' => '3',
        'presentasi' => '3',
        'uts' => '3',
        'uas' => '3',
        'total_bobot' => '3',
        'target_lls' => '100',
        ],
        [
            'id' => 2,
        'kode_clo' => '16410100121',
        'pendapat' => 'Nadim',
        'mandiri' => '3',
        'kelompok' => '3',
        'presentasi' => '3',
        'uts' => '3',
        'uas' => '3',
        'total_bobot' => '3',
        'target_lls' => '100',
        ]
    ];

    $output = [
        "draw" => $request->get('draw'),
        "recordsTotal" => count($data),
        "recordsFiltered" => count($data),
        "data" => $data
    ];
    return response()->json($output);
})->name('data-nilai-mhs');

Route::get('/testapi', [ApiController::class, 'apiwithoutKey']);
