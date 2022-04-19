<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CloController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PeoController;
use App\Http\Controllers\PeoPloController;
use App\Http\Controllers\PloController;
use App\Http\Controllers\RpsController;
use App\Models\AgendaBelajar;
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
    Route::get('/peo', [PeoController::class, 'index'])->name('peoplo.peo');
    Route::post('/peo/store', [PeoController::class, 'store'])->name('peoplo.peo.store');
    Route::get('/peo/edit', [PeoController::class, 'edit'])->name('peoplo.peo.edit');
    Route::put('/peo/update', [PeoController::class, 'update'])->name('peoplo.peo.update');
    Route::delete('/peo/delete/{id}', [PeoController::class, 'destroy'])->name('peoplo.peo.delete');

    Route::get('/plo', [PloController::class, 'index'])->name('peoplo.plo');
    Route::post('/plo/store', [PloController::class, 'store'])->name('peoplo.plo.store');
    Route::get('/plo/edit', [PloController::class, 'edit'])->name('peoplo.plo.edit');
    Route::put('/plo/update', [PloController::class, 'update'])->name('peoplo.plo.update');
    Route::delete('/plo/delete/{id}', [PloController::class, 'destroy'])->name('peoplo.plo.delete');

    Route::get('/map', [PeoPloController::class, 'index'])->name('peoplo.map');
    Route::post('/map/store', [PeoPloController::class, 'store'])->name('peoplo.map.store');
    Route::get('/map/create', [PeoPloController::class, 'create'])->name('peoplo.map.create');
    Route::delete('/map/delete/{peo}/{plo}', [PeoPloController::class, 'destroy'])->name('peoplo.map.delete');
});

Route::prefix('rps')->group(function (){


    Route::get('/', [RpsController::class,'index'])->name('rps.index');
    Route::get('/edit', [RpsController::class,'edit'])->name('rps.edit');
    Route::put('/update/{rps?}', [RpsController::class,'update'])->name('rps.update');

    Route::get('/plottingmk', [RpsController::class, 'create'])->name('rps.plottingmk');
    Route::post('/plottingmk/store', [RpsController::class, 'store'])->name('rps.plottingmk.store');

    Route::get('/clo/edit', [CloController::class, 'edit'])->name('clo.edit');
    Route::get('/clo/{rps}', [CloController::class, 'index'] )->name('clo.index');
    Route::get('/clo/create/{rps}', [CloController::class, 'create'])->name('clo.create');
    Route::post('/clo/store/{rps}', [CloController::class, 'store'])->name('clo.store');
    Route::put('/clo/update', [CloController::class, 'update'])->name('clo.update');
    Route::delete('/clo/delete/{plo}/{clo}', [CloController::class, 'destroy'])->name('clo.delete');

    Route::get('/penilaian/edit', [PenilaianController::class, 'edit'])->name('penilaian.edit');
    Route::get('/penilaian/getTotal',[PenilaianController::class, 'getTotal'])->name('penilaian.getTotal');
    Route::get('/penilaian/{rps}', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian/store/{rps}', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::put('/penilaian/update', [PenilaianController::class, 'update'])->name('penilaian.update');
    Route::put('/penilaian/updateBobot', [PenilaianController::class, 'updateBobot'])->name('penilaian.updateBobot');
    Route::delete('/penilaian/delete/{id}', [PenilaianController::class, 'destroy'])->name('penilaian.delete');

    Route::get('/agenda/listllo', [AgendaController::class, 'listLlo'])->name('llo.session.store');
    Route::post('/agenda/store/{rps}', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/agenda/{rps}', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/create/{rps}', [AgendaController::class, 'create'])->name('agenda.create');
    Route::get('/agenda/llo/delete', [AgendaController::class, 'deleteLlo'])->name('llo.session.delete');
    Route::get('/getmateri/{rps}', [AgendaController::class, 'getMateri'])->name('materi.get');
    Route::get('/storemateri', [AgendaController::class, 'storeMateri'])->name('materi.store');
    Route::get('/agenda/materi/delete', [AgendaController::class, 'deleteMateri'])->name('materi.session.delete');
    Route::get('/getsks', [AgendaController::class, 'getSks'])->name('kuliah.getSks');


    Route::get('/rangkuman/{rps}', [RpsController::class, 'rangkuman'])->name('rangkuman.index');



    Route::get('/plottingdosen', function (){

        return view('rps.plottingdsn');
    })->name('kelola.rps.plottingdsn');





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