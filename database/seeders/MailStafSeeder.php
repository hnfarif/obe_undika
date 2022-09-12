<?php

namespace Database\Seeders;

use App\Models\KaryawanDosen;
use App\Models\MailStaf;
use Illuminate\Database\Seeder;

class MailStafSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kardos = KaryawanDosen::all();
        foreach ($kardos as $i) {
            MailStaf::create([
                'nik' => $i->nik,
                'email' => 'penyusun'.$i->nik.'@dinamika.ac.id',
            ]);
        }
    }
}
