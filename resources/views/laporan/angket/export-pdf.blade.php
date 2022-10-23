<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
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
        <p>Nilai rata-rata angket tiap prodi</p>
        <table class="table table-striped" width="100%">
            <thead>
                <tr class="text-center">
                    <th>Fakultas</th>
                    <th>Nama Prodi</th>
                    <th>Rata-Rata Prodi</th>
                    <th>Rata-Rata Fakultas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fak as $f)
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
                        <div class="text-center my-3">

                            @if (isset($rataProdi[$p->id]))

                            {{ $rataProdi[$p->id]['rata_prodi'] }}

                            @endif
                        </div>
                        @endforeach
                    </td>
                    <td class="text-center">
                        @if (isset($rataFak[$f->id]))

                        {{ $rataFak[$f->id]['rata_fakultas'] }}

                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>

        @if ($prodi)
        @foreach ($prodi as $pro)
        <h5>{{ $pro->nama }}</h5>
        <table class="table table-striped" id="lapAngket" width="100%">
            <thead>
                <tr class="text-center">
                    <th>NIK</th>
                    <th>Nama Dosen</th>
                    <th>Kode MK</th>
                    <th>Nama MK</th>
                    <th>Kelas</th>
                    <th>Rata-rata</th>
                    <th>Rata-rata Dosen</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($filterAngket as $key => $fa)
                @foreach ($fa['matakuliah'] as $keymk => $mk)
                @foreach ($mk as $keykelas => $kelas)
                @if ($kelas['prodi'] == $pro->id)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $fa['nama'] }}</td>
                    <td>
                        @foreach ($fa['matakuliah'] as $keymk => $mk)
                        {!! $keymk.'<br>' !!}
                        @endforeach
                    </td>
                    <td>
                        @foreach ($fa['matakuliah'] as $keymk => $mk)

                        @foreach ($mk as $keykelas => $kelas )

                        {!! $kelas['nama'].'<br>' !!}

                        @endforeach
                        @endforeach
                    </td>
                    <td>
                        @foreach ($fa['matakuliah'] as $keymk => $mk)

                        @foreach ($mk as $keykelas => $kelas )

                        {!! $keykelas.'<br>' !!}

                        @endforeach
                        @endforeach
                    </td>
                    <td>

                        @foreach ($fa['matakuliah'] as $keymk => $mk)

                        @foreach ($mk as $keykelas => $kelas )

                        {!! number_format($kelas['rata_mk'],2).'<br>' !!}

                        @endforeach
                        @endforeach

                    </td>
                    <td>{{ $fa['rata_dosen'] }}</td>
                </tr>
                @endif
                @endforeach
                @endforeach
                @endforeach
            </tbody>
        </table>
        @endforeach

        @else
        <table class="table table-striped" id="lapAngket" width="100%">
            <thead>
                <tr class="text-center">
                    <th>NIK</th>
                    <th>Nama Dosen</th>
                    <th>Kode MK</th>
                    <th>Nama MK</th>
                    <th>Kelas</th>
                    <th>Rata-rata</th>
                    <th>Rata-rata Dosen</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($filterAngket as $key => $fa)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $fa['nama'] }}</td>
                    <td>
                        @foreach ($fa['matakuliah'] as $keymk => $mk)
                        {!! $keymk.'<br>' !!}
                        @endforeach
                    </td>
                    <td>
                        @foreach ($fa['matakuliah'] as $keymk => $mk)

                        @foreach ($mk as $keykelas => $kelas )

                        {!! $kelas['nama'].'<br>' !!}

                        @endforeach
                        @endforeach
                    </td>
                    <td>
                        @foreach ($fa['matakuliah'] as $keymk => $mk)

                        @foreach ($mk as $keykelas => $kelas )

                        {!! $keykelas.'<br>' !!}

                        @endforeach
                        @endforeach
                    </td>
                    <td>

                        @foreach ($fa['matakuliah'] as $keymk => $mk)

                        @foreach ($mk as $keykelas => $kelas )

                        {!! number_format($kelas['rata_mk'],2).'<br>' !!}

                        @endforeach
                        @endforeach

                    </td>
                    <td>{{ $fa['rata_dosen'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>

</body>

</html>
