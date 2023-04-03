<?php

namespace Database\Seeders;

use App\Models\MingguKuliah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MingguKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MingguKuliah::truncate();

        for ($i=0; $i < 16; $i++) {
            if ($i+1 == 8 || $i+1 == 16) {
                continue;
            }else{
                $miKul = new MingguKuliah();
                $miKul->jenis_smt = 'T';
                $miKul->smt = '221';
                $miKul->minggu_ke = $i+1;
                $miKul->tgl_awal = date('Y-m-d',  strtotime('+'.$i.' week'));
                $miKul->tgl_akhir = Carbon::parse($miKul->tgl_awal)->addDays(6)->format('Y-m-d');
                $miKul->save();
            }

        }
    }
}
