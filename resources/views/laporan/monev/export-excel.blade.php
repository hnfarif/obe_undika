<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>Nama MK</th>
                <th>Kelas</th>
                <th>Nama Dosen</th>
                @foreach ($kri->sortBy('id') as $k)

                <th>{{ 'Kriteria'.$loop->iteration }}</th>

                @endforeach
                <th>
                    Nilai Akhir
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jdw as $j)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>
                <td>{{ $j->getNameMataKuliah($j->klkl_id) }}</td>
                <td>{{ $j->kelas }}</td>
                <td>{{ $j->getNameKary($j->kary_nik) }}</td>
                @foreach ($kri as $k)
                @if ($loop->iteration <= 3) @if ($j->
                    cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas, $smt) ==
                    'insMon')

                    @if ($loop->iteration == '1')
                    <td>
                        <b>Instrumen Monev belum dibuat</b>
                    </td>
                    @else
                    <td class="d-none">

                    </td>
                    @endif
                    @elseif ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi,
                    $j->kelas, $smt)
                    == 'plot')
                    @if ($loop->iteration == '1')
                    <td>
                        <b>Plotting belum dibuat</b>
                    </td>
                    @else
                    <td class="d-none">

                    </td>
                    @endif
                    @else
                    @if($loop->iteration == '1')
                    <td data-bbt="{{ $k->bobot }}">
                        {{ $j->getNilaiKri1($j->kary_nik,$j->klkl_id, $j->prodi, $k->id,$j->kelas, $smt) }}
                    </td>
                    @elseif($loop->iteration == '2')
                    <td data-bbt="{{ $k->bobot }}">
                        {{ $j->getNilaiKri2($j->kary_nik,$j->klkl_id, $j->prodi, $k->id, $j->kelas, $smt) }}
                    </td>
                    @elseif($loop->iteration == '3')
                    <td data-bbt="{{ $k->bobot }}" data-prodi="{{ $j->prodi }}">
                        {{ $j->getNilaiKri3($j->kary_nik,$j->klkl_id, $j->kelas, $smt) }}
                    </td>
                    @endif
                    @endif
                    @endif
                    @endforeach
                    @if ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas,
                    $smt)
                    ==
                    'insMon' ||
                    $j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas,
                    $smt) ==
                    'plot')
                    <td class="d-none">

                    </td>
                    @else
                    <td>
                        {{ $j->getNilaiAkhir($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas, $smt) }}
                    </td>
                    @endif


            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
