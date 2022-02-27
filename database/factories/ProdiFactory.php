<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomElement(['41010', '39010']),
            'nama' => $this->faker->unique()->randomElement(['Sistem Informasi', 'Teknik Komputer']),
            'status' => $this->faker->randomElement(['0', '1']),
            'jurusan' => $this->faker->randomElement(['Sistem Informasi', 'Teknik Komputer']),
            'mngr_id' => $this->faker->randomElement(['890026','980249']),
            'alias' => $this->faker->unique()->randomElement(['SI', 'TK']),
            'sks_tempuh' => 144,
            'sts_aktif' => $this->faker->randomElement(['0', '1']),
        ];
    }
}
