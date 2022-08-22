<?php

namespace App\Exports;

use App\Models\JadwalKuliah;
use App\Models\KriteriaMonev;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MonevExport implements FromView
{
    public function view(): View
    {
        return view('laporan.monev.export-excel', [
            'kri' => KriteriaMonev::orderBy('id', 'asc')->get(),
            'jdw' => JadwalKuliah::with('matakuliahs', 'karyawans')->fakultas()->prodi()->dosen()->get(),
        ]);
    }
}
