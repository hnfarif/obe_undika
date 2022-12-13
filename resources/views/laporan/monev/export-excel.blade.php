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
                @foreach ($kri->sortBy('id') as $k)

                <th>{{ 'Kriteria'.$loop->iteration }}</th>

                @endforeach
                <th>
                    Nilai Akhir
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jdw as $j)
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
    </table>
</body>

</html>
@include('laporan.monev.script')
