<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Document</title>
</head>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table th,
    table td {
        border: 1px solid #000;
        padding: 5px;
    }

    table th {
        background-color: #ccc;
        color: #000;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #ddd;
    }

    table th {
        text-align: center;
    }

    table td {
        text-align: center;
    }

</style>

<body>
    <div style="margin-bottom: 20px;">
        <p>Dan Rata – Rata monitoring evaluasi OBE setiap Prodi adalah sebagai berikut:</p>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>Fakultas</th>
                    <th>Nama Prodi</th>
                    <th>Rata-Rata Prodi</th>
                    <th>Rata-Rata Fakultas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rata_fak as $f)
                <tr>

                    <td>{{ $f->nama }}</td>
                    <td>
                        @foreach ($f->prodis as $p )
                        <div class="my-3">

                            {{ $p->nama.' ('.$p->id.')' }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($f->prodis as $p )
                        <div class="avgMonev text-center my-3" data-prodi="{{ $p->id }}">
                            {{ number_format($p->rata, 2)}}
                        </div>
                        @endforeach
                    </td>
                    <td class="text-center">
                        {{ number_format($f->rata,2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <h5>LAMPIRAN HASIL MONITORING KETERCAPAIAN PENILAIAN DENGAN VERSI OBE</h5>
        @foreach ($prodi as $pro)
        <h5>{{ $pro->nama }}</h5>
        <table border="1" id="lapMonev" width="100%">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">
                        No
                    </th>
                    <th rowspan="2">Nama MK</th>
                    <th rowspan="2">Kelas</th>
                    <th rowspan="2">Nama Dosen</th>
                    <th rowspan="2">Pemonev</th>
                    @foreach ($kri as $k)
                    @if ($loop->iteration <= 3) <th>{{ 'Kriteria '.$loop->iteration }}</th>
                        @endif
                        @endforeach
                        <th rowspan="2">Nilai Akhir</th>
                </tr>
                <tr>
                    @foreach ($kri as $k)
                    @if ($loop->iteration <= 3) <th>{{ $k->bobot.'%' }}</th>
                        @endif
                        @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($monev->where('prodi', $pro->id) as $dm)
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
        @endforeach

    </div>

</body>

</html>
