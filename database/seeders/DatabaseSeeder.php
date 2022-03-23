<?php

namespace Database\Seeders;

use App\Models\Bagian;
use App\Models\Fakultas;
use App\Models\KaryawanDosen;
use App\Models\MailStaf;
use App\Models\Prodi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $fakultas = [
            [

                'nama' => 'Teknologi dan Informatika',
                'mngr_id' => '970229',
                'sts_aktif' => 'Y'
            ],
            [

                'nama' => 'Ekonomi dan Bisnis',
                'mngr_id' => '890032',
                'sts_aktif' => 'Y'
            ],
            [

                'nama' => 'Desain dan Indusrtri Kreatif',
                'mngr_id' => '060576',
                'sts_aktif' => 'Y'
            ],

        ];
        foreach ($fakultas as $i) {

            Fakultas::create([
                'nama' => $i['nama'],
                'mngr_id' => $i['mngr_id'],
                'sts_aktif' => $i['sts_aktif'],
            ]);
        }

        $prodi = [
            [
                'id' => '41010',
                'nama' => 'Sistem Informasi',
                'status' => '1',
                'jurusan' => 'Sistem Informasi',
                'mngr_id' => '970210',
                'sts_aktif' => 'Y',
                'id_fakultas' => 1,
            ],
            [
                'id' => '41020',
                'nama' => 'Teknik Komputer',
                'status' => '1',
                'jurusan' => 'Teknik Komputer',
                'mngr_id' => '060623',
                'sts_aktif' => 'Y',
                'id_fakultas' => 1,
            ],
            [
                'id' => '39010',
                'nama' => 'Sistem Informasi',
                'status' => '1',
                'jurusan' => 'Sistem Informasi',
                'mngr_id' => '030451',
                'sts_aktif' => 'Y',
                'id_fakultas' => 1,
            ],
            [
                'id' => '43010',
                'nama' => 'Manajemen',
                'status' => '1',
                'jurusan' => 'Manajemen',
                'mngr_id' => '910044',
                'sts_aktif' => 'Y',
                'id_fakultas' => 2,
            ],
            [
                'id' => '43020',
                'nama' => 'Akuntansi',
                'status' => '1',
                'jurusan' => 'Akuntansi',
                'mngr_id' => '880019',
                'sts_aktif' => 'Y',
                'id_fakultas' => 2,
            ],
            [
                'id' => '39015',
                'nama' => 'Administrasi Perkantoran',
                'status' => '1',
                'jurusan' => 'Administrasi Perkantoran',
                'mngr_id' => '970230',
                'sts_aktif' => 'Y',
                'id_fakultas' => 2,
            ],
            [
                'id' => '42010',
                'nama' => 'Desain Komunikasi Visual',
                'status' => '1',
                'jurusan' => 'Desain Komunikasi Visual',
                'mngr_id' => '160851',
                'sts_aktif' => 'Y',
                'id_fakultas' => 3,
            ],
            [
                'id' => '42020',
                'nama' => 'Desain Produk',
                'status' => '1',
                'jurusan' => 'Desain Produk',
                'mngr_id' => '140824',
                'sts_aktif' => 'Y',
                'id_fakultas' => 3,
            ],
            [
                'id' => '51016',
                'nama' => 'Produksi Film dan Televisi',
                'status' => '1',
                'jurusan' => 'Produksi Film dan Televisi',
                'mngr_id' => '100716',
                'sts_aktif' => 'Y',
                'id_fakultas' => 3,
            ],

        ];
        foreach ($prodi as $i) {

            Prodi::create([
                'id' => $i['id'],
                'nama' => $i['nama'],
                'status' => $i['status'],
                'jurusan' => $i['jurusan'],
                'mngr_id' => $i['mngr_id'],
                'sts_aktif' => $i['sts_aktif'],
                'id_fakultas' => $i['id_fakultas'],
            ]);
        }

        $bagian = [
            [
                'kode' => '1',
                'nama' => 'P3kM',
            ],
            [
                'kode' => '2',
                'nama' => 'P3AI',
            ],
            [
                'kode' => '3',
                'nama' => 'International Office',
            ],
            [
                'kode' => '4',
                'nama' => 'Pusat Kerjasama',
            ],
            [
                'kode' => '5',
                'nama' => 'PPTI',
            ],
        ];

        foreach ($bagian as $i ) {

            Bagian::create([
                'kode' => $i['kode'],
                'nama' => $i['nama'],

            ]);
        }

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

        foreach ($kardos as $i) {

            KaryawanDosen::create([
                'nik' => $i['nik'],
                'nama' => $i['nama'],
                'fakul_id' => $i['fakul_id'],
                'bagian' => $i['bagian'],
                'pin' => $i['pin'],
            ]);
        }

        foreach ($kardos as $i) {
            MailStaf::create([
                'nik' => $i['nik'],
                'email' => 'hnfarif18@gmail.com',
            ]);
        }
        // \App\Models\User::factory(10)->create();
        \App\Models\MataKuliah::factory(10)->create();
    }
}
