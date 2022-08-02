<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CloController;
use App\Http\Controllers\InstrumenMonevController;
use App\Http\Controllers\InstrumenNilaiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PeoController;
use App\Http\Controllers\PeoPloController;
use App\Http\Controllers\PloController;
use App\Http\Controllers\PlottingMonevController;
use App\Http\Controllers\RpsController;
use App\Http\Controllers\UserController;
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
Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('ensureUserRole:kaprodi,bagian,dosenBagian,dosen');

Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

//socialize routes

Route::get('sign-in-google', [UserController::class, 'google'])->name('user.login.google');
Route::get('auth/google/callback', [UserController::class, 'handleProviderCallback'])->name('user.google.callback');

Route::prefix('kelola')->middleware('ensureUserRole:kaprodi,bagian,dosen,dosenBagian')->group(function () {
    Route::get('/peo', [PeoController::class, 'index'])->name('peoplo.peo');
    Route::post('/peo/store', [PeoController::class, 'store'])->name('peoplo.peo.store')->middleware('ensureUserRole:kaprodi,bagian');
    Route::get('/peo/edit', [PeoController::class, 'edit'])->name('peoplo.peo.edit')->middleware('ensureUserRole:kaprodi,bagian');
    Route::put('/peo/update', [PeoController::class, 'update'])->name('peoplo.peo.update')->middleware('ensureUserRole:kaprodi,bagian');
    Route::delete('/peo/delete/{id}', [PeoController::class, 'destroy'])->name('peoplo.peo.delete')->middleware('ensureUserRole:kaprodi,bagian');

    Route::get('/plo', [PloController::class, 'index'])->name('peoplo.plo');
    Route::post('/plo/store', [PloController::class, 'store'])->name('peoplo.plo.store')->middleware('ensureUserRole:kaprodi,bagian');
    Route::get('/plo/edit', [PloController::class, 'edit'])->name('peoplo.plo.edit')->middleware('ensureUserRole:kaprodi,bagian');
    Route::put('/plo/update', [PloController::class, 'update'])->name('peoplo.plo.update')->middleware('ensureUserRole:kaprodi,bagian');
    Route::delete('/plo/delete/{id}', [PloController::class, 'destroy'])->name('peoplo.plo.delete')->middleware('ensureUserRole:kaprodi,bagian');

    Route::get('/map', [PeoPloController::class, 'index'])->name('peoplo.map');
    Route::post('/map/store', [PeoPloController::class, 'store'])->name('peoplo.map.store')->middleware('ensureUserRole:kaprodi,bagian');
    Route::get('/map/create', [PeoPloController::class, 'create'])->name('peoplo.map.create')->middleware('ensureUserRole:kaprodi,bagian');
    Route::delete('/map/delete/{peo}/{plo}', [PeoPloController::class, 'destroy'])->name('peoplo.map.delete')->middleware('ensureUserRole:kaprodi,bagian');
});

Route::prefix('rps')->middleware('ensureUserRole:bagian,dosen,dosenBagian')->group(function (){


    Route::get('/', [RpsController::class,'index'])->name('rps.index');
    Route::get('/edit', [RpsController::class,'edit'])->name('rps.edit');
    Route::put('/update/{rps?}', [RpsController::class,'update'])->name('rps.update');
    Route::put('/file/store', [RpsController::class,'saveFileRps'])->name('rps.file.store');
    Route::put('/trfAgd', [RpsController::class,'transferAgenda'])->name('rps.transferAgenda');

    Route::get('/plottingrps', [RpsController::class, 'create'])->name('rps.plottingrps');
    Route::post('/plottingrps/store', [RpsController::class, 'store'])->name('rps.plottingrps.store');

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

    Route::get('/agenda/edit', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::put('/agenda/update', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/agenda/delete/{id}/{rps}', [AgendaController::class, 'destroy'])->name('agenda.delete');
    Route::get('/agenda/listllo', [AgendaController::class, 'listLlo'])->name('llo.session.store');
    Route::post('/agenda/store/{rps}', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/agenda/{rps}', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/create/{rps}', [AgendaController::class, 'create'])->name('agenda.create');
    Route::get('/agenda/llo/delete', [AgendaController::class, 'deleteLlo'])->name('llo.session.delete');
    Route::get('/getmateri/{rps}', [AgendaController::class, 'getMateri'])->name('materi.get');
    Route::get('/getmateri/edit/{rps}', [AgendaController::class, 'getMateriEdit'])->name('materi.edit');
    Route::get('/storemateri', [AgendaController::class, 'storeMateri'])->name('materi.store');
    Route::get('/addmateri', [AgendaController::class, 'addMateri'])->name('materi.add');
    Route::get('/removeMateri', [AgendaController::class, 'removeMateri'])->name('materi.remove');
    Route::get('/agenda/materi/delete', [AgendaController::class, 'deleteMateri'])->name('materi.session.delete');
    Route::get('/agenda/materi/deleteall', [AgendaController::class, 'delAllMateri'])->name('materi.session.deleteall');
    Route::get('/getsks', [AgendaController::class, 'getSks'])->name('kuliah.getSks');
    Route::get('/getLlo', [AgendaController::class, 'getLlo'])->name('create.getLlo');
    Route::get('/session/getLlo', [AgendaController::class, 'getLloSession'])->name('create.session.getLlo');

    Route::put('/update-tgl-agenda', [AgendaController::class, 'uptDate'])->name('agenda.uptDate');

    Route::get('/rangkuman/{rps}', [RpsController::class, 'rangkuman'])->name('rangkuman.index');

});

Route::prefix('penilaian')->name('penilaian.')->group(function (){

    Route::get('/cekrps', [InstrumenNilaiController::class, 'cekRps'])->name('cekrps');

    Route::put('/nilaimin', [InstrumenNilaiController::class, 'uptNilaiMin'])->name('putNilaiMin');

    Route::post('/save-summary', [InstrumenNilaiController::class, 'storeSummary'])->name('storeSummary');

    Route::resource('clo', InstrumenNilaiController::class);
});

Route::prefix('monev')->name('monev.')->group(function(){

    Route::get('/kriteria/create', [PlottingMonevController::class, 'createCriteria'])->name('createCriteria');

    Route::post('/kriteria/store', [PlottingMonevController::class, 'storeCriteria'])->name('storeCriteria');

    Route::get('/kriteria/show', [PlottingMonevController::class, 'showCriteria'])->name('showCriteria');

    Route::put('/kriteria/update', [PlottingMonevController::class, 'updateCriteria'])->name('updateCriteria');

    Route::delete('/kriteria/delete/{id}', [PlottingMonevController::class, 'deleteCriteria'])->name('deleteCriteria');

    Route::get('/plot/detail', [PlottingMonevController::class, 'detailPlot'])->name('detailPlot');

    Route::get('/list', [InstrumenMonevController::class, 'listMonev'])->name('listMonev');

    Route::resource('plotting', PlottingMonevController::class);
    Route::resource('instrumen', InstrumenMonevController::class);
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
