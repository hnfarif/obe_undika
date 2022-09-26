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

    .page-break {
        page-break-after: always;
    }

</style>

<body>
    <p>Rincian tiap badge : </p>
    <div style="margin-bottom: 20px;">
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>Badges</th>
                    <th>Jumlah</th>
                    <th>%</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rangBadge as $b)

                <tr>
                    <td>{{ $b['nama'] }}</td>
                    <td>{{ $b['jumlah'] }}</td>
                    <td>{{ $b['persen'] }}</td>
                    <td>{{ $b['avg'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p>Dengan penjabaran untuk masing-masing Fakultas dan Prodi adalah :</p>
    <div style="margin-bottom: 20px;">
        <p>- Fakultas</p>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>Fakultas</th>
                    <th>Kategori</th>
                    <th>Jumlah Kelas</th>
                    <th>%</th>
                    <th>Nilai</th>
                    <th>Nilai Akhir Fakultas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rataFak as $f)
                <tr>

                    <td>{{ $f['nama'] }}</td>
                    <td>
                        @foreach ($f['kategori'] as $k)
                        <div class="my-3">

                            {{ $k['nama'] }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($f['kategori'] as $k)
                        <div class="my-3">

                            {{ $k['jumlah'] }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($f['kategori'] as $k)
                        <div class="my-3">

                            {{ $k['persen'] }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($f['kategori'] as $k)
                        <div class="my-3">

                            {{ $k['nilai'] }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        {{ $f['nilai_akhir'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <p>- Prodi</p>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>Program Studi</th>
                    <th>Kategori</th>
                    <th>Jumlah Kelas</th>
                    <th>%</th>
                    <th>Nilai</th>
                    <th>Nilai Akhir Prodi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rataProdi as $f)
                <tr>

                    <td>{{ $f['nama'] }}</td>
                    <td>
                        @foreach ($f['kategori'] as $k)
                        <div class="my-3">

                            {{ $k['nama'] }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($f['kategori'] as $k)
                        <div class="my-3">

                            {{ $k['jumlah'] }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($f['kategori'] as $k)
                        <div class="my-3">

                            {{ $k['persen'] }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($f['kategori'] as $k)
                        <div class="my-3">

                            {{ $k['nilai'] }}
                        </div>
                        @endforeach
                    </td>
                    <td>
                        {{ $f['nilai_akhir'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
