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
                <div class="my-3">
                    <a href="{{ route('monev.plotting.create') }}" type="button" class="btn btn-primary"><i
                            class="fas fa-plus"></i> Entri
                        Plotting Monev</a>

                    <a href="{{ route('monev.createCriteria') }}" type="button" class="btn btn-primary"><i
                            class="fas fa-plus"></i> Entri Kriteria Penilaian</a>
                </div>
                <div class="d-flex align-items-center my-0">
                    <div class="ml-auto">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="plot" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Daftar Plotting</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optvclo" value="kriMon" class="selectgroup-input">
                                <span class="selectgroup-button">Kriteria Penilaian Monev</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row plot">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar monev</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tableMonev">
                                        <thead>
                                            <tr class="text-center">
                                                <th>
                                                    Prodi
                                                </th>
                                                <th>Kode MK</th>
                                                <th>Mata Kuliah</th>
                                                <th>Kelas</th>
                                                <th>NIK</th>
                                                <th>Nama Dosen</th>
                                                <th>Ruang</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($pltMnv as $m)
                                            <tr>
                                                <td>
                                                    {{ $m->prodi }}
                                                </td>
                                                <td>{{ $m->klkl_id }}</td>
                                                <td>{{ $m->getNameMataKuliah($m->klkl_id, $m->prodi) }}</td>
                                                <td>
                                                    {{ $m->getKelasRuang($m->klkl_id, $m->nik_pengajar)['kelas'] }}
                                                </td>
                                                <td>
                                                    {{ $m->nik_pengajar }}
                                                </td>
                                                <td>
                                                    {{ $m->getNameKary($m->nik_pengajar) }}
                                                </td>
                                                <td>
                                                    {{ $m->getKelasRuang($m->klkl_id, $m->nik_pengajar)['ruang'] }}
                                                </td>
                                                <td><a href="{{ route('monev.instrumen.index', ['id' => $m->id]) }}"
                                                        class="btn btn-success btn-sm text-sm">Buat Instrumen Monev</a>
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
                                                    ID
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

                                            @foreach ($kri as $k)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $k->id }}
                                                </td>
                                                <td>
                                                    {{ $k->kategori }}
                                                </td>
                                                <td>
                                                    {{ $k->kri_penilaian }}
                                                </td>
                                                <td>
                                                    {{ $k->deskripsi }}
                                                </td>
                                                <td>
                                                    {{ $k->bobot }}
                                                </td>
                                                <td class="d-flex my-auto">
                                                    <button type="button" class="btn btn-light editKri mr-2"
                                                        data-id="{{ $k->id }}" data-toggle="modal"
                                                        data-target="#editKri"><i class="fas fa-edit"></i>
                                                    </button>

                                                    <form action="{{ route('monev.deleteCriteria', $k->id) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <a href="#" class="btn btn-danger delKri"><i
                                                                class="fas fa-trash"></i>

                                                        </a>
                                                    </form>
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
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>
@include('plotting-monev.modal-edit-kri')
@endsection
@push('script')
@include('plotting-monev.script')
@endpush
