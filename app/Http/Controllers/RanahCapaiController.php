<?php

namespace App\Http\Controllers;

use App\Imports\RanahImport;
use App\Models\RanahCapai;
use App\Models\Semester;
use Illuminate\Http\Request;
use Excel;

class RanahCapaiController extends Controller
{

    private $semester;

    public function __construct()
    {
        $this->semester = Semester::orderBy('smt_yad', 'desc')->first()->smt_yad;
    }

    public function index()
    {
        $smt = $this->semester;
        $ranah = RanahCapai::all();
        return view('ranah-capai.index', compact('smt','ranah'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'file_excel' => 'required|mimes:xls,xlsx|max:2048'
        ]);

        $file = $request->file('file_excel');

        Excel::import(new RanahImport, $file);

        return redirect()->back()->with('success', 'Data berhasil diimport');
    }
}
