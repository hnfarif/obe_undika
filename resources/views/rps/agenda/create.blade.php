@extends('layouts.main')
@section('rps', 'active')
@section('agenda', 'active')
@section('content')
<style>
    .input-group .select2-container {
        width: 92% !important;
        padding: 0;
    }

</style>
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            @include('rps.section-header')
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="section-title mt-0">Table Tambah Data Agenda Pembelajaran</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12 mb-3 d-flex">
                        <button type="button" class="btn btn-primary" id="btnFormClo" data-toggle="modal"
                            data-target="#formAgenda"> <i class="fas fa-plus"></i> Tambah data</button>
                        <form class="ml-auto" action="{{ route('agenda.store', $rps->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="week" id="week">
                            <button type="submit" class="btn btn-success ml-auto" id="btnSaveAgd"> <i
                                    class="fas fa-save"></i>
                                Simpan Data</button>

                        </form>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12 mb-3">
                        <label>Pilih Minggu</label>
                        <select class="form-control @error('week') is-invalid @enderror select2" id="optweek" required>
                            <option selected disabled> Pilih Minggu</option>
                            @for ($i = 1; $i <= 14; $i++) <option value="{{ $i }}">{{ 'Minggu Ke '.$i }}</option>
                                @endfor
                        </select>
                        @error('week')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                </div>
                <div class="row row-input">

                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped table-responsive" id="tableLlo">
                                    <thead>
                                        <tr>

                                            <th rowspan="2" class="align-middle text-center">Kode CLO</th>
                                            <th rowspan="2" class="align-middle text-center">Kode LLO</th>
                                            <th rowspan="2" class="align-middle text-center">
                                                <div style="min-width: 100px;">
                                                    Deskripsi LLO
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle text-center">
                                                <div style="min-width: 150px;">
                                                    Ketercapaian
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle text-center">
                                                <div style="min-width: 150px;">
                                                    Bentuk Penilaian
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle text-center">
                                                <div style="min-width: 150px;">
                                                    Pengalaman Belajar
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle text-center">
                                                <div style="min-width: 150px;">
                                                    Materi
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle text-center">
                                                <div style="min-width: 150px;">
                                                    Metode
                                                </div>
                                            </th>
                                            <th colspan="4">

                                                <div class="align-middle text-center" style="min-width: 150px;">
                                                    Kuliah (menit/mg)
                                                </div>
                                            </th>
                                            <th rowspan="2" class="align-middle text-center">
                                                Responsi dan Tutorial
                                                (menit/mg)

                                            </th>
                                            <th rowspan="2" class="align-middle text-center">
                                                Belajar Mandiri
                                                (menit/mg)

                                            </th>
                                            <th rowspan="2" class="align-middle text-center">
                                                Praktikum
                                                (menit/mg)

                                            </th>
                                            <th rowspan="2" class="align-middle text-center">Aksi</th>
                                        </tr>
                                        <tr>
                                            <th>TM</th>
                                            <th>SL</th>
                                            <th>ASL</th>
                                            <th>ASM</th>
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
        </section>
    </div>
    @include('layouts.footer')
</div>

@include('rps.agenda.modalagd')

@endsection
@push('script')
@include('rps.agenda.script-create')
@endpush
