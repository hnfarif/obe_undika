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
                @if ($loop->last)

                <th>{{ 'Kriteria 3' }}</th>
                @endif
                @endforeach
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
                @if ($loop->last)
                @if ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) == 'insMon')

                <td class="text-warning text-center">
                    <b>Instrumen Monev belum dibuat</b>
                </td>
                @elseif ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) == 'plot')
                <td class="text-danger text-center">
                    <b>Plotting belum dibuat</b>
                </td>
                @else
                <td data-bbt="{{ $k->bobot }}" data-prodi="{{ $j->prodi }}">
                    {{ $j->getNilaiKri3($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) }}
                </td>
                @endif
                @endif

                @endforeach

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
@include('laporan.monev.script')
