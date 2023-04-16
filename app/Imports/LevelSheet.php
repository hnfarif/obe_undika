<?php

namespace App\Imports;

use App\Models\LevelRanah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LevelSheet implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $collection->each(function ($row) {
            LevelRanah::updateOrCreate(
                [
                    'kode_ranah' => $row['kode_ranah'],
                    'kode_level' => $row['kode_level'],
                    'nama' => $row['nama_level'],
                ]
            );
        });
    }
}
