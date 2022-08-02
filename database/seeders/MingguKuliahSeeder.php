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

        for ($i=0; $i < 16; $i++) {
            $miKul = new MingguKuliah();
            $miKul->jenis_smt = '1';
            $miKul->smt = '202';
            $miKul->minggu_ke = $i+1;
            $miKul->tgl_awal = date('Y-m-d',  strtotime('+'.$i.' week'));
            $miKul->tgl_akhir = Carbon::parse($miKul->tgl_awal)->addDays(6)->format('Y-m-d');
            $miKul->save();

        }
    }
}
