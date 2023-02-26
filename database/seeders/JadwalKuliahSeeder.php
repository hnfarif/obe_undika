<?php

namespace Database\Seeders;

use App\Models\JadwalKuliah;
use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class JadwalKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kardos = [
            [
                'nik' => '910049',
                'nama' => 'Dr. M.J. Dewiyani Sunarto',
                'fakul_id' => '41010',
                'bagian' => 1,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '110752',
                'nama' => 'Edo Yonatan Koentjoro, S.Kom., M.Sc.',
                'fakul_id' => '39010',
                'bagian' => 1,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '160853',
                'nama' => 'Musayyanah, S.ST., M.T.',
                'fakul_id' => '41020',
                'bagian' => 1,
                'pin' => substr(bcrypt('123456'), 6),


            ],
            [
                'nik' => '970210',
                'nama' => 'Dr. Anjik Sukmaaji, S.Kom., M.Eng.',
                'fakul_id' => '41010',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '120772',
                'nama' => 'Endra Rahmawati, M.Kom.',
                'fakul_id' => '41010',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '050521',
                'nama' => 'Tony Soebijono, S.E., S.H., M.Ak.',
                'fakul_id' => '43020',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '160851',
                'nama' => 'Dhika Yuan Yurisma, M.Ds., ACA',
                'fakul_id' => '42010',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '200901',
                'nama' => 'Fenty Fahminnansih, S.T., M.MT.',
                'fakul_id' => '42010',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '150847',
                'nama' => 'Candraningrat, S.E., M.SM.',
                'fakul_id' => '43010',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '140821',
                'nama' => 'Krisna Yuwono Fora, M.T., ACA',
                'fakul_id' => '51016',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '030451',
                'nama' => 'Nunuk Wahyuningtyas, M.Kom',
                'fakul_id' => '39010',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '980220',
                'nama' => 'Didiet Anindita Arnandy, M.Kom.',
                'fakul_id' => '39010',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '040477',
                'nama' => 'Darwin Yuwono Riyanto, S.T., M.Med.Kom.,ACA',
                'fakul_id' => '42020',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '040501',
                'nama' => 'Vivine Nurcahyawati, M.Kom., OCP',
                'fakul_id' => '41010',
                'bagian' => 2,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '200899',
                'nama' => 'Angen Yudho Kisworo, S.Pd., M. TESOL',
                'fakul_id' => '39015',
                'bagian' => 3,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '060623',
                'nama' => 'Pauladie Susanto, S.Kom., M.T.',
                'fakul_id' => '41020',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '130803',
                'nama' => 'Yosefine Triwidyastuti, M.T.',
                'fakul_id' => '41020',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '020393',
                'nama' => 'Tan Amelia, S.Kom., M.MT., MCP',
                'fakul_id' => '41010',
                'bagian' => 4,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '980249',
                'nama' => 'Erwin Sutomo, S.Kom., M.Eng.',
                'fakul_id' => '41010',
                'bagian' => 5,
                'pin' => substr(bcrypt('123456'), 6),

            ],
            [
                'nik' => '970229',
                'nama' => 'Tri Sagirani, S.Kom., M.MT.',
                'fakul_id' => '41010',
                'bagian' => null,
                'pin' => substr(bcrypt('123456'), 6),

            ],
        ];

        $mk = MataKuliah::all();

        foreach ($kardos as $k){

            foreach ($mk as $m) {
                if ($m->fakul_id == '41010') {
                    JadwalKuliah::create([
                        'kary_nik' => $k['nik'],
                        'klkl_id' => $m->id,
                        'kelas' => 'P1',
                        'hari' => 1,
                        'mulai' => date('Y-m-d H:i:s'),
                        'selesai' => date('Y-m-d H:i:s', strtotime('+1 hour')),
                        'kapasitas' => 30,
                        'terisi' => 20,
                        'isi_temp' => 0,
                        'sts_kul' => "1",
                        'ruang_id' => "MY202",
                        'prodi' => $k['fakul_id'],
                        'sks' => $m['sks'],
                    ]);
                }

            }
        }
    }
}
