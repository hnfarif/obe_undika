<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KaryawanDosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        return [
            'nik' => $this->faker->unique()->numberBetween('456700','456710'),
            'kary_type' => $this->faker->randomElement(['TD', 'T']),
            'nama' => $this->faker->name,
            'alamat' => $this->faker->address,
            'kot_id' => $this->faker->numerify('####'),
            'sex' => $this->faker->numberBetween(1,2),
            'sts_marital' => $this->faker->numberBetween(1,3),
            'wn' => $this->faker->numberBetween(1,2),
            'agama' => $this->faker->numberBetween(1,5),
            'shift' => $this->faker->randomElement(['A', 'B', 'C']),
            'fakul_id' => '41010',
            'nip' => $this->faker->numerify('######'),
            'telp' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['A', 'B', 'C']),
            'bagian' => $this->faker->numberBetween(1,5),
            'absensi' => $this->faker->numberBetween(1,2),
            'pin' => '123456',
            'sts_pin' => $this->faker->randomElement(['Y', 'T']),
            'manager_id' => $this->faker->randomElement(['890026','980249']),
            'mulai_kerja' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'tgl_keluar' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'kelompok' => 'Normal Pagi',
            'inisial' => $first_name[0] . $first_name[1] . $last_name[0],
            'kode_sie' => $this->faker->numberBetween(1,3),
            'adm' => $this->faker->numberBetween(1,2),
            'dosen' => 4,
            'gelar_depan' => $this->faker->randomElement(['Dr', 'Ir', 'Prof', 'Prof Dr']),
            'gelar_belakang' => $this->faker->randomElement(['S.M', 'S.H', 'S.Pd', 'S.Pt', 'S.Pd', 'S.Pt']),
            'pin_b' => $this->faker->numerify('######'),
            'ktp' => $this->faker->numerify('######'),
            'kk' => $this->faker->numerify('######'),
            'nidk' => $this->faker->numerify('######'),
            'nup' => $this->faker->numerify('######'),

        ];
    }
}
