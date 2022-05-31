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

            {{-- @include('rps.section-header') --}}
            <div class="section-body">
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Instrumen Nilai Mahasiswa</h2>

                </div>
                {{-- <p class="section-lead">Masukkan, ubah data PEO </p> --}}

                <div class="row">
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
                                            @endforeach

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
                                                <input type="hidden" id="nim" value="{{ $k->mhs_nim }}">
                                                <input type="number"
                                                    value="{{ $pen->detailInstrumenNilai->where('mhs_nim', $k->mhs_nim)->first()->nilai ?? '' }}"
                                                    max="100"
                                                    min="0"
                                                    class="form-control text-center nilai" style="min-width:60px;">
                                            </td>
                                            @endforeach
                                            <td></td>
                                            @endforeach
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
