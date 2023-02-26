<?php

namespace Database\Seeders;

use App\Models\AngketTrans;
use App\Models\JadwalKuliah;
use App\Models\Semester;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;

class AngketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    public function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    public function run()
    {
        $jdw = JadwalKuliah::all();

        foreach ($jdw as $val) {
            $smt = Semester::where('fak_id', $val->prodi)->first();
            AngketTrans::create([
                'nik' => $val->kary_nik,
                'kode_mk' => $val->klkl_id,
                'kelas' => $val->kelas,
                'smt' => $smt->smt_yad,
                'smt_mk' => $smt->smt_aktif,
                'nilai' => $this->faker->numberBetween(0, 4),
                'prodi' => $val->prodi,
          ]);
        }
    }
}
