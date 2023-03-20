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
        {{-- <table border="1" width="100%">
            <thead>
                <tr>
                    <th>Fakultas</th>
                    <th>Nama Prodi</th>
                    <th>Rata-Rata Prodi</th>
                    <th>Rata-Rata Fakultas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fakul as $f)
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
                {{ $p->getAvgMonev($p->id, $smt) }}
            </div>
            @endforeach
        </td>
        <td class="text-center">
            {{ $f->getAvgMonevFakul($f->id, $smt) }}
        </td>
        </tr>
        @endforeach
        </tbody>
        </table> --}}
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
                @foreach ($jdw->where('prodi', $pro->id) as $j)
                <tr>
                    <td class="text-center">
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
                        <td class="text-warning text-center" colspan="4">
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
                        <td class="text-danger text-center" colspan="4">
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
                        <td id="naMonev">
                            {{ $j->getNilaiAkhir($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas, $smt) }}
                        </td>
                        @endif


                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach

    </div>

</body>

</html>
