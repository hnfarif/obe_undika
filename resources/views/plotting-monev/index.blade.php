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
                <div class="my-3 d-flex">
                    <a href="{{ route('monev.plotting.create') }}" type="button" class="btn btn-primary"><i
                            class="fas fa-plus"></i> Entri
                        Plotting Monev</a>

                    <a href="{{ route('monev.createCriteria') }}" type="button" class="btn btn-primary  ml-3"><i
                            class="fas fa-plus"></i> Entri Kriteria Penilaian</a>

                    <button class="btn btn-light ml-3" data-toggle="modal" data-target="#filPlot">
                        <i class="fas fa-filter"></i> Filter
                    </button>

                    <form class="card-header-form ml-3 @if (auth()->user()->role == 'dosen') ml-auto @endif"
                        action="{{ route('monev.plotting.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama matakuliah"
                                value="{{ request('search') }}">
                            <div class="input-group-btn d-flex">
                                <button class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
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
                                <h4>Daftar Plotting</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tableMonev">
                                        <thead>
                                            <tr class="text-center">
                                                <th>NIK</th>
                                                <th>Nama Dosen</th>
                                                <th>Semester</th>
                                                <th>Jumlah MK terplotting</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($pltMnv->unique('nik_pemonev') as $m)
                                            <tr>
                                                <td>
                                                    {{ $m->nik_pemonev }}
                                                </td>
                                                <td>
                                                    {{ $m->getNameKary($m->nik_pemonev) }}
                                                </td>
                                                <td>
                                                    {{ $m->semester }}
                                                </td>
                                                <td>
                                                    {{ $m->cnPlot($m->nik_pemonev, $m->semester) }}
                                                </td>
                                                <td><a href="{{ route('monev.detailPlot', ['nik' => $m->nik_pemonev, 'smt' => $m->semester]) }}"
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
@include('plotting-monev.modal')
@endsection
@push('script')
@include('plotting-monev.script')
@endpush
