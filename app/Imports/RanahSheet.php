<?php

namespace App\Imports;

use App\Models\RanahCapai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class RanahSheet implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $collection->each(function ($row) {
            RanahCapai::updateOrCreate(
                [
                    'kode' => $row['kode'],
                    'nama' => $row['nama'],
                    'inisial' => $row['inisial'],
                    'deskripsi' => $row['deskripsi'],
                ]
            );
        });
    }
}
