<div class="my-3 d-flex">
    <button class="btn btn-light ml-auto" data-toggle="modal" data-target="#filInsClo">
        <i class="fas fa-filter"></i> Filter
    </button>
</div>
<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Instrumen Penilaian CLO</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableJdw">
                        <thead>
                            <tr class="text-center">
                                <th>NIK</th>
                                <th>Nama Dosen</th>
                                <th>Prodi</th>
                                <th>Jumlah MK diampu</th>
                                <th>Jumlah Instrumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($kary as $k)
                            @if ($jdwkul->where('kary_nik', $k->nik)->count() == 0)
                            @continue
                            @else
                            <tr class="text-center">
                                <td>
                                    {{ $k->nik }}
                                </td>
                                <td class="text-left">
                                    {{ $k->nama }}
                                </td>
                                <td class="text-left">
                                    {{ $k->prodi->nama }}
                                </td>
                                <td>
                                    {{ $jdwkul->where('kary_nik', $k->nik)->count() }}
                                </td>
                                <td>

                                    {{ $instru->where('nik', $k->nik)->where('semester', $smt)->count() }}

                                </td>
                                <td><a href="{{ route('penilaian.detailInstrumen', ['nik' => $k->nik]) }}"
                                        class="btn btn-primary btn-sm text-sm">Detail</a>
                                </td>
                            </tr>
                            @endif
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
