<?php

namespace App\Http\Controllers;

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
        if ($kary->bagian) {
            $nama = $kary->bagianKary->nama;
            $nick = $kary->bagianKary->nick;
            if ($nama == 'PIMPINAN') {
                $roles[] = 'pimpinan';
            }else if($nick == 'P3AI'){
                $roles[] = 'p3ai';
            }
        }

        if ($chkDosen) {
            $roles[] = 'dosen';
        }
        if ($chkKaprodi) {
            $roles[] = 'kaprodi';
        }
        // dd($roles);
        return view('beranda.index', compact('roles'));
    }
}
