<?php

namespace Database\Seeders;

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
        Semester::create([
            'fak_id' => '41010',
            'smt_aktif' => '202',
            'smt_yad' => '211',
            'smt_lain' => '201',
        ]);
    }
}
