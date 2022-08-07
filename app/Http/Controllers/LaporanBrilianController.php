<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanBrilianController extends Controller
{
    public function index()
    {
        return view('laporan.brilian');
    }
}
