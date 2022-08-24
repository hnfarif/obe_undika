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
                        <div class="text-center my-3" data-prodi="{{ $p->id }}">

                            {{ $p->getAvgAngket($p->id) }}
                        </div>
                        @endforeach
                    </td>
                    <td class="text-center">
                        {{ $f->getAvgAngketFakul($f->id) }}
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
                </tr>

            </thead>
            <tbody>
                @foreach ($filterAngket->where('prodi', $pro->id) as $fa)
                <tr>
                    <td>{{ $fa->nik }}</td>
                    <td>{{ $fa->karyawan->nama ?? 'Nama Belum ada di database' }}</td>
                    <td>{{ $fa->kode_mk }}</td>
                    <td>{{ $fa->getMatakuliahName($fa->prodi,$fa->kode_mk) }}
                    </td>
                    <td>{{ $fa->kelas }}</td>
                    <td data-prodi="{{ $fa->prodi }}">{{ number_format($fa->nilai,2) }}</td>
                </tr>
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
                </tr>

            </thead>
            <tbody>
                @foreach ($filterAngket as $fa)
                <tr>
                    <td>{{ $fa->nik }}</td>
                    <td>{{ $fa->karyawan->nama ?? 'Nama Belum ada di database' }}</td>
                    <td>{{ $fa->kode_mk }}</td>
                    <td>{{ $fa->getMatakuliahName($fa->prodi,$fa->kode_mk) }}
                    </td>
                    <td>{{ $fa->kelas }}</td>
                    <td data-prodi="{{ $fa->prodi }}">{{ number_format($fa->nilai,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>

</body>

</html>
