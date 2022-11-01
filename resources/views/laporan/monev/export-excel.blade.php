<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table id="lapMonev" width="100%">
        <thead>
            <tr>
                <th class="text-center">
                    No
                </th>
                <th>Nama MK</th>
                <th>Kelas</th>
                <th>Nama Dosen</th>
                @foreach ($kri as $k)

                <th>{{ $loop->iteration }}</th>

                @endforeach
                <th>
                    Nilai Akhir
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jdw as $j)
            <tr>
                <td class="text-center">
                    {{ $loop->iteration }}
                </td>
                <td>{{ $j->getNameMataKuliah($j->klkl_id) }}</td>
                <td>{{ $j->kelas }}</td>
                <td>{{ $j->getNameKary($j->kary_nik) }}</td>
                @foreach ($kri as $k)

                @if ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) == 'insMon')

                @if ($loop->iteration == '1')
                <td class="text-warning text-center" colspan="4">
                    <b>Instrumen Monev belum dibuat</b>
                </td>
                @endif
                @elseif ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) == 'plot')
                @if ($loop->iteration == '1')
                <td class="text-danger text-center" colspan="4">
                    <b>Plotting belum dibuat</b>
                </td>
                @endif
                @else
                @if($loop->iteration == '1')
                <td data-bbt="{{ $k->bobot }}">
                    {{ $j->getNilaiKri1($j->kary_nik,$j->klkl_id, $j->prodi, $k->id, $j->kelas) }}
                </td>
                @elseif($loop->iteration == '2')
                <td data-bbt="{{ $k->bobot }}">
                    {{ $j->getNilaiKri2($j->kary_nik,$j->klkl_id, $j->prodi, $k->id, $j->kelas) }}
                </td>
                @elseif($loop->iteration == '3')
                <td data-bbt="{{ $k->bobot }}" data-prodi="{{ $j->prodi }}">
                    {{ $j->getNilaiKri3($j->kary_nik,$j->klkl_id, $j->kelas) }}
                </td>
                @endif
                @endif
                @endforeach
                @if ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) != 'insMon' &&
                $j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) != 'plot')
                <td>
                    {{ $j->getNilaiAkhir($j->kary_nik, $j->klkl_id, $j->prodi, $j->kelas) }}
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
@include('laporan.monev.script')
