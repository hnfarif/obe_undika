<?php

namespace App\Exports;

use App\Http\Controllers\LaporanMonevController;
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
        $monevController = new LaporanMonevController();
        $monev = $monevController->manipulateMonev();

        return view('laporan.monev.export-excel', [
            'kri' => KriteriaMonev::orderBy('id', 'asc')->get(),
            'monev' => $monev,
        ]);
    }
}
