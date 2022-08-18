<?php

namespace Database\Seeders;

use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prodi = Prodi::all();
        foreach ($prodi as $p ) {
            Semester::create([
                'fak_id' => $p->id,
                'smt_aktif' => '202',
                'smt_yad' => '211',
                'smt_lain' => '201',
            ]);
        }

    }
}
