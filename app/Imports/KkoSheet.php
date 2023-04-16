<?php

namespace App\Imports;

use App\Models\Kko;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KkoSheet implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $collection->each(function ($row) {
            Kko::updateOrCreate(
                [
                    'kode_ranah' => $row['kode_ranah'],
                    'kode_level' => $row['kode_level'],
                    'no' => $row['no'],
                    'kata' => $row['kata'],
                ]
            );
        });
    }
}
