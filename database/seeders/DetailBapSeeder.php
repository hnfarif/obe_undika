<?php

namespace Database\Seeders;

use App\Models\AgendaBelajar;
use App\Models\Bap;
use App\Models\DetailAgenda;
use App\Models\DetailBap;
use App\Models\JadwalKuliah;
use App\Models\MateriKuliah;
use App\Models\MingguKuliah;
use App\Models\Rps;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DetailBapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bap = Bap::all();

        foreach ($bap as $key => $value) {
            $jdw = JadwalKuliah::where('klkl_id', $value->kode_mk)->get();

            foreach ($jdw as $kjdw => $valjdw) {
                if (substr($value->kode_bap, 0, 10) == '9702104721' && $valjdw->kary_nik == '970210' && $valjdw->klkl_id == '4721') {
                    $smt = Semester::where('fak_id', $valjdw->prodi)->first();
                    $rps = Rps::where('kurlkl_id', $value->prodi.$value->kode_mk)->where('is_active', 1)->where('semester', $smt->smt_aktif)->first();
                    $agd = AgendaBelajar::where('rps_id', $rps->id)->where('pekan', $value->pertemuan)->first();
                    $dtlagd = DetailAgenda::where('agd_id', $agd->id)->pluck('id')->toArray();
                    $mtr = MateriKuliah::whereIn('dtl_agd_id', $dtlagd)->pluck('materi')->toArray();
                    $filNull = array_filter($mtr);
                    $filDuplicate = array_unique($filNull);
                    $materi = implode(', ', $filDuplicate);

                    DetailBap::create([
                        'kode_bap' => $value->kode_bap,
                        'kelas' => $valjdw->kelas,
                        'semester' => $smt->smt_aktif,
                        'nik' => $valjdw->kary_nik,
                        'realisasi' => $materi,
                        'waktu_entry' => Carbon::parse($valjdw->mulai)->addDays($value->pertemuan * 7)->format('Y-m-d H:i:s'),
                        'prodi' => $value->prodi,
                    ]);
                }

            }


        }
    }
}
