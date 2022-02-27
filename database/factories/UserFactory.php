<?php

namespace Database\Factories;

use App\Models\KaryawanDosen;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nik = KaryawanDosen::select('nik')->pluck('nik')->toArray();
        $nama = KaryawanDosen::select('nama')->pluck('nama')->toArray();
        return [
            'nik' => $this->faker->unique()->randomElement($nik),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => $this->faker->numerify('######'), // password
            'manager_id' => $this->faker->randomElement(['890026','980249']) ,
            'fakul_id' => $this->faker->randomElement(['41010', '39010']),
            'kode_bagian' => $this->faker->numberBetween(1,5),
            'dosen' => 4,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
