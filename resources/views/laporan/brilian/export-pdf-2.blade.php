<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Document</title>
</head>

<style>
    * {
        font-family: 'Times New Roman', Times, serif;
        font-size: 10px;
    }

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

    .page-break {
        page-break-after: always;
    }

</style>

<body>
    <p>LAMPIRAN MONITORING BRILIAN PER MINGGU : </p>
    <div>
        @if ($prodi)
        @foreach ($prodi as $pro)
        <h5>{{ $pro->nama }}</h5>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">
                        Dosen
                    </th>
                    <th rowspan="2">Nama MK</th>
                    <th rowspan="2">Kode MK</th>
                    <th rowspan="2">Kelas</th>
                    <th rowspan="2">Prodi</th>
                    @foreach ($indikator as $i)
                    <th colspan="2">{{ 'Kriteria '.$loop->iteration }}</th>
                    @endforeach
                    <th rowspan="2">Skor Total</th>

                    @foreach ($week as $w)

                    <th rowspan="2">{{ 'Nilai M'.$w['minggu_ke'] }}</th>
                    @endforeach

                    <th rowspan="2">Badges</th>
                </tr>
                <tr>
                    @foreach ($indikator as $i)
                    <th>{{ $i['nama'] }}</th>
                    <th>Skor</th>
                    @endforeach
                </tr>

            </thead>
            <tbody>
                @foreach (collect($data)->where('prodi', $pr['id']) as $d)
                <tr>
                    <td>

                        {{ $d->nama_dosen }}
                    </td>
                    <td>{{ $d->nama_course }}</td>
                    <td>{{ $d->kode_mk }}</td>
                    <td>{{ $d->kelas }}</td>
                    <td>{{ $d->prodi }}</td>
                    @foreach ($d->jml_modul as $j)
                    <td>
                        {{ $j }}
                    </td>
                    <td>
                        {{ $d->skor[$loop->index] }}
                    </td>
                    @endforeach
                    <td>
                        {{ $d->skor_total }}
                    </td>
                    @foreach ($week as $w)

                    <td>
                        {{ number_format(collect($dtlBri)->where('brilian_week_id', $w['id'])->where('nik', $d->nik)->where('kode_mk', $d->kode_mk)->where('kelas', $d->kelas)->where('prodi', $d->prodi)->first()['nilai'], 2) ?? '' }}
                    </td>
                    @endforeach
                    <td>
                        {{ $d->badge }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach

        @else
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">
                        Dosen
                    </th>
                    <th rowspan="2">Nama MK</th>
                    <th rowspan="2">Kode MK</th>
                    <th rowspan="2">Kelas</th>
                    <th rowspan="2">Prodi</th>
                    @foreach ($indikator as $i)
                    <th colspan="2">{{ 'Kriteria '.$loop->iteration }}</th>
                    @endforeach
                    <th rowspan="2">Skor Total</th>

                    @foreach ($week as $w)

                    <th rowspan="2">{{ 'Nilai M'.$w['minggu_ke'] }}</th>
                    @endforeach

                    <th rowspan="2">Badges</th>
                </tr>
                <tr>
                    @foreach ($indikator as $i)
                    <th>{{ $i['nama'] }}</th>
                    <th>Skor</th>
                    @endforeach
                </tr>

            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>

                        {{ $d['nama_dosen'] }}
                    </td>
                    <td>{{ $d['nama_course'] }}</td>
                    <td>{{ $d['kode_mk'] }}</td>
                    <td>{{ $d['kelas'] }}</td>
                    <td>{{ $d['prodi'] }}</td>
                    @foreach ($d['jml_modul'] as $j)
                    <td>
                        {{ $j }}
                    </td>
                    <td>
                        {{ $d['skor'][$loop->index] }}
                    </td>
                    @endforeach
                    <td>
                        {{ $d['skor_total'] }}
                    </td>
                    @foreach ($week as $w)

                    <td>
                        {{ number_format(collect($dtlBri)->where('brilian_week_id', $w['id'])->where('nik', $d['nik'])->where('kode_mk', $d['kode_mk'])->where('kelas', $d['kelas'])->where('prodi', $d['prodi'])->first()['nilai'], 2) ?? '' }}
                    </td>
                    @endforeach
                    <td>
                        {{ $d['badge'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</body>
