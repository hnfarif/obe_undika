<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('peoplo')->group(function () {
    Route::get('/step-1', function () {
        return view('kelolapeoplo.kelolapeo');
    })->name('peoplo.peo');
    Route::get('/step-2', function () {
        return view('kelolapeoplo.kelolaplo');
    })->name('peoplo.plo');
    Route::get('/step-3', function () {
        return view('kelolapeoplo.mapping');
    })->name('peoplo.mapping');
});

Route::prefix('rps')->group(function (){

    Route::get('/', function (){

        return view('rps.index');
    })->name('kelola.rps');
});



Route::get('/testapi', [ApiController::class, 'apiwithoutKey']);
