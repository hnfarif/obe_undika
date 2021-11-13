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
        return view('kelolapeoplo.step1');
    })->name('peoplo.step1');
    Route::get('/step-2', function () {
        return view('kelolapeoplo.step2');
    })->name('peoplo.step2');
    Route::get('/step-3', function () {
        return view('kelolapeoplo.step3');
    })->name('peoplo.step3');
});



Route::get('/testapi', [ApiController::class, 'apiwithoutKey']);
