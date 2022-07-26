<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MataKuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numerify('41010#####'),
            'semester' => $this->faker->numberBetween(1,6),
            'nama' => $this->faker->unique()->randomElement(['Sistem Pendukung Keputusan', 'Logika Dan Algoritma Pemrograman', 'Statistik Dan Probabilitas','Basis Data','Pemrograman Dasar', 'Pemrograman Basis Data', 'Pemrograman Web Dasar', 'Pemrograman Berbasis Mobile', 'Analisa Dan Perancangan Sistem', 'Data Mining']),
            'sks' => $this->faker->numberBetween(1,6),
            'status' => 1,
            'fakul_id' => '41010',
            'jenis' => $this->faker->numberBetween(1,3),
            'tahun' => $this->faker->numberBetween(2010,2022),
            'min_nilai' => $this->faker->randomElement(['A', 'B+', 'B', 'C+', 'C']),
        ];
    }
}
