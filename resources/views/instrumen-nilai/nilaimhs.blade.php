@extends('layouts.main')
@section('instrumen-nilai', 'active')
@section('content')
<style>
    table.dataTable.table-striped.DTFC_Cloned tbody tr:nth-of-type(odd) {
        background-color: #F3F3F3;
    }

    table.dataTable.table-striped.DTFC_Cloned tbody tr:nth-of-type(even) {
        background-color: white;
    }

</style>
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Target CLO</h2>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Target CLO</h4>
                            </div>
                            <div class="card-body">
                                <table class="table-sm table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th>ID CLO</th>
                                            <th>Presentase</th>
                                            <th>Target Nilai (minimal)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dtlAgd->unique('clo_id') as $da)
                                        <tr class="text-center">
                                            <td>{{ $da->clo->kode_clo }}</td>
                                            <td>{{ $dtlAgd->where('penilaian_id', '<>', null)->where('clo_id', $da->clo_id)->sum('bobot') }}
                                                %
                                            </td>
                                            <td>{{ $da->clo->nilai_min }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title titleClo">Instrumen Nilai Mahasiswa</h2>
                    <div class="ml-auto">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="1" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Penilaian CLO</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="0" class="selectgroup-input">
                                <span class="selectgroup-button">Rangkuman CLO</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row penClo">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <h4>Daftar Nilai Mahasiswa</h4>
                                <button class="btn btn-primary ml-auto btnSimpanNilai" disabled><i
                                        class="fas fa-save"></i> Simpan
                                    Penilaian
                                    CLO</button>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped table-responsive" width="100%" id="tableIns">
                                    <thead>
                                        <tr>

                                            <th rowspan="4" class="align-middle text-center">NIM</th>
                                            <th rowspan="4" class="align-middle text-center">Nama Mahasiswa</th>
                                            @foreach ($dtlAgd->unique('clo_id') as $da)

                                            <th
                                                colspan="{{ $dtlAgd->where('clo_id', $da->clo_id)->where('penilaian_id', '<>', null)->count() }}">

                                                {{ $da->clo->kode_clo }}


                                            </th>
                                            <th rowspan="4" class="align-middle text-center bg-light">

                                                Total
                                                {{ $da->clo->kode_clo }}
                                            </th>
                                            <th rowspan="4" class="align-middle text-center bg-light">
                                                Nilai Konversi
                                            </th>
                                            <th rowspan="4" class="align-middle text-center bg-light">
                                                Status Kelulusan (T/TL)
                                            </th>
                                            @endforeach

                                            <th rowspan="4" class="align-middle text-center ">Nilai Mentah Akhir
                                                OBE
                                            </th>

                                            <th rowspan="4" class="align-middle text-center ">Nilai Huruf OBE</th>

                                            <th rowspan="4" class="align-middle text-center">Status
                                                Kelulusan OBE (L/TL)
                                            </th>
                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th>{{ $pen->penilaian->btk_penilaian}}</th>
                                            @endforeach
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th>{{ $pen->penilaian->jenis}}</th>
                                            @endforeach
                                            @endforeach

                                        </tr>
                                        <tr>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <th>{{ $pen->bobot.'%'}}</th>
                                            @endforeach
                                            @endforeach

                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($krs as $k)
                                        <tr>
                                            <td>
                                                {{ $k->mhs_nim }}
                                            </td>
                                            <td>

                                                {{ $k->mahasiswa->nama }}
                                            </td>
                                            @foreach ($dtlAgd->unique('clo_id') as $cl)
                                            @foreach ($dtlAgd->where('clo_id', $cl->clo_id)->where('penilaian_id', '<>', null) as
                                            $pen)

                                            <td>
                                                <input type="hidden" id="idDtlAgd" value="{{ $pen->id }}">
                                                <input type="hidden" id="bobot" value="{{ $pen->bobot }}">
                                                <input type="hidden" id="nim" value="{{ $k->mhs_nim }}">
                                                <input type="number"
                                                    value="{{ $pen->detailInstrumenNilai->where('mhs_nim', $k->mhs_nim)
                                                    ->where('ins_nilai_id', $idIns)->first()->nilai ?? '' }}"
                                                    max="100"
                                                    min="0"
                                                    class="form-control text-center nilai" data-cl="{{ $cl->clo_id }}" style="min-width:60px;">
                                            </td>
                                            @endforeach
                                            <td class="text-center align-middle ttlClo" data-cl="{{ $cl->clo_id }}"></td>

                                            <td class="text-center align-middle nKvs"
                                            data-sumbobot="{{ $dtlAgd->where('penilaian_id', '<>', null)->where('clo_id', $cl->clo_id)->sum('bobot') }}" data-cl="{{ $cl->clo_id }}">

                                            </td>

                                            <td class="text-center align-middle stsLulus" data-cl="{{ $cl->clo_id }}"
                                            data-nilaimin="{{ $cl->clo->nilai_min }}"
                                            >

                                            </td>
                                            @endforeach
                                            <td class="align-middle text-center naObe" ></td>
                                            <td class="align-middle text-center nhObe"></td>
                                            <td class="align-middle text-center stsaLulus"></td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2"></th>
                                            @foreach ($dtlAgd->unique('clo_id') as $da)

                                            <th class="text-right" colspan="{{ $dtlAgd->where('clo_id', $da->clo_id)->where('penilaian_id', '<>', null)->count() }}">
                                            Rata - Rata untuk {{ $da->clo->kode_clo }}
                                            </th>

                                            <th class="text-center align-middle avgTtl" data-cl="{{ $da->clo_id }}"></th>

                                            <th class="text-center align-middle avgKvs" data-cl="{{ $da->clo_id }}">
                                            </th>

                                            <th class="text-center align-middle avgStsLulus"
                                            data-cl="{{ $da->clo_id }}"
                                            data-nilaimin="{{ $da->clo->nilai_min }}"
                                            >

                                            </th>
                                            @endforeach
                                        </tr>
                                    </tfoot>
                                </table>


                            </div>
                        </div>

                    </div>
                </div>

                <div class="row rangClo d-none">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                               <h4>Rangkuman CLO</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-responsive" width="100%">
                                    <thead>
                                        <tr class="text-center align-middle">
                                            <th>ID CLO</th>
                                            <th>Target CLO</th>
                                            <th>Rata - rata Nilai Capaian CLO</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah Mahasiswa memenuhi target</th>
                                            <th>Jumlah Mahasiswa belum memenuhi target</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($dtlAgd->unique('clo_id') as $da)

                                        <tr class="text-center align-middle">
                                            <td style="width:100px;">
                                                {{ $da->clo->kode_clo }}
                                            </td>
                                            <td class="tgtClo">
                                                {{ $da->clo->nilai_min }}
                                            </td>
                                            <td class="rangAvgKvs" data-cl="{{ $da->clo_id }}">

                                            </td>
                                            <td class="rangKet">

                                            </td>
                                            <td class="rangJmlLulus" data-cl="{{ $da->clo_id }}">

                                            </td>
                                            <td class="rangJmlTl" data-cl="{{ $da->clo_id }}">

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


        </section>
    </div>
    @include('layouts.footer')
</div>
@endsection
@push('script')
@include('instrumen-nilai.script-nilaimhs')
@endpush
