<?php

namespace Database\Seeders;

use App\Models\Bap;
use App\Models\JadwalKuliah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jdw = JadwalKuliah::all();

        foreach ($jdw as $key => $j) {
            if ($j->kary_nik == '910049' && $j->klkl_id == '4721') {
                for ($i=1; $i <= 14; $i++) {
                    $bap = new Bap();
                    $bap->kode_bap = $key + 1 . $i;
                    $bap->kode_mk = $j->klkl_id;
                    $bap->pertemuan = $i;
                    $bap->waktu_entry = Carbon::now();
                    $bap->prodi = $j->prodi;

                    $bap->save();
                }
            }


        }
    }
}
