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
                <th>Pemonev</th>
                @foreach ($kri as $k)
                @if ($loop->iteration <= 3) <th>{{ 'Kriteria '.$loop->iteration. ' ('. $k->bobot.'%) ' }}</th>
                    @endif
                    @endforeach
                    <th rowspan="2">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monev as $dm)
            <tr>
                <td class="text-center">
                    {{ $loop->iteration }}
                </td>
                <td>{{ $dm->getNameMataKuliah($dm->klkl_id) }}</td>
                <td>{{ $dm->kelas }}</td>
                <td>{{ $dm->karyawan->nama }}</td>
                <td>{{ $dm->dosenPemonev->nama }}</td>
                <td>{{ $dm->kri_1 }}</td>
                <td>{{ $dm->kri_2 }}</td>
                <td>{{ $dm->kri_3 }}</td>
                <td>{{ $dm->na }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
