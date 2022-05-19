<?php

namespace Database\Factories;

use App\Models\JadwalKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

class KrsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   $jdw = JadwalKuliah::pluck('klkl_id')->toArray();
        return [
            'jkul_kelas' => 'P1',
            'jkul_klkl_id' => $this->faker->randomElement($jdw),
            'mhs_nim' => $this->faker->numerify('1841010###')
        ];
    }
}
