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
        return view('ranah-capai.index', compact('smt'));
    }

    public function store(Request $request)
    {
        $file = $request->file('file_excel')->store('temp');

        Excel::import(new RanahImport, $file);

        return redirect()->back();
    }
}
