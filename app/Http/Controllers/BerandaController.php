<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Fakultas;
use App\Models\KaryawanDosen;
use App\Models\Prodi;
use Illuminate\Http\Request;

class BerandaController extends Controller
{

    public function index()
    {
        $nik = auth()->user()->nik;
        $roles = [];
        $kary = KaryawanDosen::with('bagianKary')->where('nik', $nik)->first();
        $chkDosen = $kary->fakul_id;
        $chkKaprodi = Prodi::where('mngr_id', $nik)->first(); // cek kaprodi atau bukan
        $chkDekan = Fakultas::where('mngr_id', $nik)->first(); // cek dekan atau bukan
        $nama = $kary->bagianKary->nama;

        $nick = Bagian::whereKode($kary->bagian)->first()->nick;

        if ($nama == 'PIMPINAN') {
            $roles[] = 'pimpinan';

        }

        if(stripos($nick, 'P3AI') !== false){
            $roles[] = 'p3ai';
        }

        if ($chkDosen) {
            $roles[] = 'dosen';
        }
        if ($chkKaprodi) {
            $roles[] = 'kaprodi';
        }
        if ($chkDekan) {
            $roles[] = 'dekan';
        }
        // dd($roles);
        return view('beranda.index', compact('roles'));
    }
}
