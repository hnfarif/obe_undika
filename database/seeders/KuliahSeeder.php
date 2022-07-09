<?php

namespace Database\Seeders;

use App\Models\JadwalKuliah;
use App\Models\Kuliah;
use Illuminate\Database\Seeder;

class KuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jdwkul = JadwalKuliah::all();

        foreach ($jdwkul as $j) {
            if ($j->klkl_id == '4721') {
                for ($i=0; $i < 14; $i++) {
                    Kuliah::create([
                        'jkul_kelas' => $j->kelas,
                        'jkul_kary_nik' => $j->kary_nik,
                        'jkul_klkl_id' =>  $j->prodi.$j->klkl_id,
                        'tanggal' => date('Y-m-d',  strtotime('+'.$i.' week')),
                        'ruang_id' => $j->ruang_id,
                        'prodi' => $j->prodi,
                        'sks' => $j['sks'],
                    ]);
                }
            }
        }
    }
}
