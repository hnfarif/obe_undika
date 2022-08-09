<?php

namespace Database\Seeders;

use App\Models\JadwalKuliah;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $jdw = JadwalKuliah::all();
        $mhs = Mahasiswa::all();
        foreach ($jdw as $j) {
            foreach ($mhs as $m) {
                Krs::create([
                    'jkul_kelas' => 'P1',
                    'jkul_klkl_id' => $j->klkl_id,
                    'kary_nik' => $j->kary_nik,
                    'mhs_nim' => $m->nim,
                ]);
            }
        }

    }
}
