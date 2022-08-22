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

<body>
    <div class="mb-5">
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>Fakultas</th>
                    <th>Nama Prodi</th>
                    <th>Rata-Rata</th>
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
                        <div class="avgMonev my-3" data-prodi="{{ $p->id }}">

                        </div>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <table border="1 solid black" id="lapMonev" width="100%">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">
                        No
                    </th>
                    <th rowspan="2">Nama MK</th>
                    <th rowspan="2">Kelas</th>
                    <th rowspan="2">Nama Dosen</th>
                    @foreach ($kri as $k)
                    <th>{{ 'Kriteria '.$loop->iteration }}</th>
                    @endforeach
                    <th rowspan="2">Nilai Akhir</th>
                </tr>
                <tr>
                    @foreach ($kri as $k)
                    <th>{{ $k->bobot.'%' }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($jdw as $j)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $j->getNameMataKuliah($j->klkl_id,$j->prodi) }}</td>
                    <td>{{ $j->kelas }}</td>
                    <td>{{ $j->karyawans->nama }}</td>
                    @foreach ($kri as $k)

                    @if ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi) == 'insMon')

                    @if ($loop->iteration == '1')
                    <td class="text-warning text-center" colspan="4">
                        <b>Instrumen Monev belum dibuat</b>
                    </td>
                    @endif
                    @elseif ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi) == 'plot')
                    @if ($loop->iteration == '1')
                    <td class="text-danger text-center" colspan="4">
                        <b>Plotting belum dibuat</b>
                    </td>
                    @endif
                    @else
                    @if($loop->iteration == '1')
                    <td data-bbt="{{ $k->bobot }}">
                        {{ $k->getNilaiKri1($j->kary_nik,$j->klkl_id, $j->prodi, $k->id) }}
                    </td>
                    @elseif($loop->iteration == '2')
                    <td data-bbt="{{ $k->bobot }}">
                        {{ $k->getNilaiKri2($j->kary_nik,$j->klkl_id, $j->prodi, $k->id) }}
                    </td>
                    @elseif($loop->iteration == '3')
                    <td data-bbt="{{ $k->bobot }}" data-prodi="{{ $j->prodi }}">
                        {{ $k->getNilaiKri3($j->kary_nik,$j->klkl_id, $j->prodi, $j->kelas) }}
                    </td>
                    @endif
                    @endif
                    @endforeach
                    @if ($j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi) != 'insMon' &&
                    $j->cekKriteria($j->kary_nik,$j->klkl_id, $j->prodi) != 'plot')
                    <td id="naMonev">

                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="test">

    </div>

    <script>
        document.getElementById("test").innerHTML = "whatever";
        $(document).ready(function () {
            $('#naMonev').each(function () {
                var kri3 = parseFloat($(this).prev().text());
                var kri2 = parseFloat($(this).prev().prev().text());
                var kri1 = parseFloat($(this).prev().prev().prev().text());

                var bbt3 = parseFloat($(this).prev().data('bbt') / 100);
                var bbt2 = parseFloat($(this).prev().prev().data('bbt') / 100);
                var bbt1 = parseFloat($(this).prev().prev().prev().data('bbt') / 100);

                var na = (kri3 * bbt3) + (kri2 * bbt2) + (kri1 * bbt1);
                $(this).text(na.toFixed(2));

            });

            $('.avgMonev').each(function () {
                var id = $(this).data('prodi');
                var count = 0;
                var sum = 0;
                $('#naMonev').each(function () {

                    var na = parseFloat($(this).text());
                    var prodi = $(this).prev().data('prodi');

                    if (prodi == id) {
                        count++;
                        sum += na;
                    }

                })
                var avg = sum / count;
                $(this).text(avg.toFixed(2));

            })
        });

    </script>


</body>

</html>
