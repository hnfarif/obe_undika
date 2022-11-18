<div class="my-3 d-flex">
    <button class="btn btn-light ml-auto" data-toggle="modal" data-target="#filInsClo">
        <i class="fas fa-filter"></i> Filter
    </button>
</div>

<div class="d-flex align-items-center">
    <div class="ml-auto">
        <div class="selectgroup w-100">
            <label class="selectgroup-item">
                <input type="radio" name="optrangclo" value="dafIns" class="selectgroup-input" checked="">
                <span class="selectgroup-button">Daftar Instrumen</span>
            </label>
            <label class="selectgroup-item">
                <input type="radio" name="optrangclo" value="rangCapaiClo" class="selectgroup-input">
                <span class="selectgroup-button">Grafik Ketercapaian CLO</span>
            </label>
        </div>
    </div>
</div>

<div class="row dafIns">

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

                            @foreach ($jdwkul->unique('kary_nik') as $k)

                            <tr class="text-center">
                                <td>
                                    {{ $k->kary_nik }}
                                </td>
                                <td class="text-left">
                                    {{ $k->getNameKary($k->kary_nik) }}
                                </td>
                                <td class="text-left">
                                    {{ $k->getNameProdi($k->prodi) }}
                                </td>
                                <td>
                                    {{ $jdwkul->where('kary_nik', $k->kary_nik)->count() }}
                                </td>
                                <td>

                                    {{ $instru->where('nik', $k->kary_nik)->where('semester', $smt)->count() }}

                                </td>
                                <td><a href="{{ route('penilaian.detailInstrumen', ['nik' => $k->kary_nik]) }}"
                                        class="btn btn-primary btn-sm text-sm">Detail</a>
                                </td>
                            </tr>

                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row rangCapaiClo d-none">
    <div class="loadGrafik">

    </div>
    <div class="col-12 col-lg-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Grafik Ketercapaian CLO Mata Kuliah</h4>
            </div>
            <div class="card-body">
                <canvas id="grangclo" width="700" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
