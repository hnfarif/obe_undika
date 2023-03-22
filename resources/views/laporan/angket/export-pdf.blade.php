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

    .text-left {
        text-align: left;
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
                @foreach ($rata as $f)
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
        @foreach ($rata as $f)
        @foreach ($f->prodis as $p)
        <h5>{{ $p->nama }}</h5>
        <table class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama Dosen</th>
                    <th>Nama MK dan rata-rata</th>
                    <th>Rata-rata Dosen</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($angket as $key => $a)
                @if ($a->where('prodi', $p->id))
                <tr>
                    <td>{{ $key }}</td>
                    <td>
                        @if ($a[0]->karyawan)

                        {{ $a[0]->karyawan->nama }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        <ul>
                            @foreach ($a->unique('kode_mk') as $keymk => $mk)
                            <li>
                                {{ $mk->getMatakuliahName($mk->kode_mk).' ('. $mk->kode_mk.') '. $mk->kelas. ' : '. number_format($a->where('kode_mk', $mk->kode_mk)->avg('nilai'), 2)
                            }}
                            </li>
                            @endforeach
                        </ul>

                    </td>

                    <td>
                        {{ number_format($a->avg('nilai'), 2) }}
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        @endforeach
        @endforeach
    </div>
</body>

</html>
