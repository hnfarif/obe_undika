<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanAngketController extends Controller
{
    public function index()
    {
        return view('laporan.angket');
    }
}
