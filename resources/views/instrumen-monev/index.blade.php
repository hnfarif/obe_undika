@extends('layouts.main')
@section('plottingmonev', 'active')
@section('', 'active')
@section('content')

<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="d-flex align-items-center my-0">
                    <div class="ml-auto">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="plot" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Instrumen Monev</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="kriMon" class="selectgroup-input">
                                <span class="selectgroup-button">Rangkuman</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row plot">
                    @foreach ($kri->sortBy('id') as $k)
                    @if($loop->iteration == 1)
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="d-flex align-items-center my-0">
                            <h2 class="section-title titleClo">Kriteria {{ $loop->iteration }}</h2>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <table class="table table-bordered table-responsive" width="100%" id="kri-1">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center align-middle">
                                                Kriteria
                                            </th>
                                            <th rowspan="2" class="align-middle ">Keterangan</th>
                                            <th rowspan="2" class="align-middle border">Bobot</th>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            <th colspan="{{ $dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null)->count() }}"
                                                class="border">
                                                {{ $cl->clo->kode_clo }}
                                            </th>
                                            @endforeach
                                            <th rowspan="2" class="align-middle border">Evaluasi</th>

                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th class="border">
                                                {{ $pen->penilaian->btk_penilaian}}
                                            </th>

                                            @endforeach
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="min-width: 200px;" rowspan="2" class="">

                                                {{ $k->kri_penilaian }}
                                            </td>
                                            <td class="align-middle text-center border" >
                                                RPS
                                            </td>
                                            <td rowspan="2" class="text-center align-middle border">
                                                {{ $k->bobot }}
                                            </td>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                                $pen)

                                                <td class="border">
                                                    {{ 'M'.$pen->agendaBelajar->pekan}}
                                                </td>

                                            @endforeach
                                            @endforeach
                                            <td class="align-middle border eval-kri-1" rowspan="2">
                                                tes
                                            </td>

                                        </tr>

                                        <tr class="eval">

                                            <td class="align-middle text-center border">Evaluasi CLO</td>

                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                                $pen)

                                                <td class="border nilai-kri-1">
                                                    {{ $dtlInsMon->where('dtl_agd_id', $pen->id)->first()->nilai ?? '' }}
                                                </td>

                                            @endforeach
                                            @endforeach

                                        </tr>


                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    @elseif ($loop->iteration == 2)
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="d-flex align-items-center my-0">
                            <h2 class="section-title titleClo">Kriteria {{ $loop->iteration }}</h2>

                            <button class="ml-auto btn btn-primary"> <i class="fas fa-save"></i> Simpan </button>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <table class="table table-striped table-responsive" id="tableMonev">
                                    <thead>
                                        <tr class="text-center">
                                            <th>
                                                Kriteria
                                            </th>
                                            <th>Bobot</th>
                                            @foreach ($agd->sortBy('pekan') as $a)
                                            @if (!($a->pekan == 'UTS' || $a->pekan == 'UAS'))

                                            <th>{{ 'M'.$a->pekan }}</th>
                                            @endif
                                            @endforeach
                                            <th>Persentase</th>
                                            <th>Nilai Kesesuaian</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td style="min-width: 150px;">

                                                {{ $k->kri_penilaian }}
                                            </td>
                                            <td>
                                                {{ $k->bobot }}
                                            </td>
                                            @foreach ($agd as $a)
                                            @if (!($a->pekan == 'UTS' || $a->pekan == 'UAS'))
                                            <td style="min-width: 50px;">
                                                <input type="number" class="form-control text-center" min="0" max="4">
                                            </td>
                                            @endif
                                            @endforeach
                                            <td>

                                            </td>
                                            <td></td>
                                        </tr>


                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    @elseif($loop->iteration == 3)
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="d-flex align-items-center my-0">
                            <h2 class="section-title titleClo">Kriteria {{ $loop->iteration }}</h2>
                        </div>
                        <div class="card">
                            <div class="card-body d-flex">

                                <table class="table table-bordered" id="tableMonev">
                                    <thead>
                                        <tr class="text-center">

                                            <th>
                                                Kriteria
                                            </th>
                                            <th>Keterangan</th>
                                            <th>Bobot (%)</th>
                                            <th>Nilai</th>
                                            <th>Evaluasi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">

                                        <tr>

                                            <td style="min-width: 150px;" rowspan="4">

                                                {{ $k->kri_penilaian }}
                                            </td>
                                            <td>
                                                JML
                                            </td>
                                            <td rowspan="4">
                                                {{ $k->bobot }}
                                            </td>

                                            <td rowspan="4">

                                            </td>
                                            <td rowspan="4">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                JMK
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                JMP
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                ILC
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div class="ml-3">
                                    <p>*JML = Jumlah Mahasiswa Yang Lulus Semua CLO</p>
                                    <p>*JMK = Jumlah Mahasiswa dalam 1 Kelas</p>
                                    <p>*JMP = Jumlah Mahasiswa Terkena Presensi</p>
                                    <p>*ILC = Indeks Lulus CLO</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endif
                    @endforeach


                </div>
                <div class="row kriMon d-none">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Kriteria</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-responsive" id="tableKri">
                                        <thead>
                                            <tr class="text-center">
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    Kategori
                                                </th>
                                                <th>Kriteria Penilaian</th>
                                                <th style="min-width: 200px;">
                                                    Deskripsi
                                                </th>
                                                <th>Bobot (%)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>
@endsection
@push('script')
@include('instrumen-monev.script')
@endpush
