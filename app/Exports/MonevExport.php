<?php

namespace App\Exports;

use App\Models\JadwalKuliah;
use App\Models\KriteriaMonev;
use App\Models\PlottingMonev;
use App\Models\Semester;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MonevExport implements FromView
{
    public function view(): View
    {
        $smt = Semester::orderBy('smt_yad', 'desc')->first();
        $plot = PlottingMonev::whereSemester($smt->smt_yad)->pluck('klkl_id')->toArray();

        return view('laporan.monev.export-excel', [
            'kri' => KriteriaMonev::orderBy('id', 'asc')->get(),
            'jdw' => JadwalKuliah::whereIn('klkl_id', $plot)->with('matakuliahs', 'karyawans')->fakultas()->prodi()->dosen()->get(),
        ]);
    }
}
