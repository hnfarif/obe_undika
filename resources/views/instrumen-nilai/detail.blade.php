@extends('layouts.main')
@section('instrumen-nilai', 'active')
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
                    <h5>{{ 'Daftar Instrumen Penilaian CLO - '.$kary->nama }}</h5>
                    <form class="card-header-form ml-auto" action="{{ route('penilaian.clo.index') }}">
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
                    <h2 class="section-title">Mata Kuliah Lulus</h2>
                </div>
                <div class="row">
                    @foreach ($mkLulus as $jdw)
                    <div class="col-12 col-md-12 col-lg-4">
                        <div
                            class="card @if ($instru->where('klkl_id', $jdw->klkl_id)->where('nik',$jdw->kary_nik)->first()) card-primary @else card-warning @endif">
                            <div class="card-header" style="height: 100px;">
                                <div class="d-block">
                                    <h4 class="text-dark">{{ $jdw->getNameMataKuliah($jdw->klkl_id) }}
                                        ({{ $jdw->klkl_id }})</h4>
                                    <p class="m-0">{{ $jdw->getNameProdi($jdw->prodi) }}</p>
                                </div>
                                <div class="card-header-action ml-auto">
                                    <a data-collapse="#{{ $jdw->klkl_id.$jdw->kelas }}" class="btn btn-icon btn-info"
                                        href="#"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="collapse" id="{{ $jdw->klkl_id.$jdw->kelas }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-between">
                                            <div>
                                                <b>Kelas</b>
                                                <p>{{ $jdw->kelas }}</p>
                                            </div>
                                            <div>
                                                <b>SKS</b>
                                                <p>{{ $jdw->sks }}</p>
                                            </div>
                                            <div>
                                                <b>Ruang</b>
                                                <p>{{ $jdw->ruang_id }}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button data-mk="{{ $jdw->klkl_id }}" data-nik="{{ $jdw->kary_nik }}"
                                    data-kelas="{{ $jdw->kelas }}" class="btn @if ($instru->where('klkl_id', $jdw->klkl_id)->where('nik',$jdw->kary_nik)->where('kelas', $jdw->kelas)->first())
                                    btn-primary @else btn-warning @endif btn-sm btnUbahNilai">

                                    @if($instru->where('klkl_id', $jdw->klkl_id)->where('nik',
                                    $jdw->kary_nik)->where('kelas',
                                    $jdw->kelas)->first()) Lihat Instrumen
                                    @else
                                    Buat Instrumen
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if($mkLulus->isEmpty())
                    <div class="col-12">
                        <div class="alert alert-info">
                            Tidak ada data
                        </div>
                    </div>
                    @endif
                </div>
                <div class="d-flex align-items-center my-0">
                    <h2 class="section-title">Mata Kuliah Tidak Lulus</h2>
                </div>
                <div class="row">
                    @foreach ($mkTdkLulus as $jdw)
                    <div class="col-12 col-md-12 col-lg-4">
                        <div
                            class="card @if ($instru->where('klkl_id', $jdw->klkl_id)->where('nik',$jdw->kary_nik)->first()) card-primary @else card-warning @endif">
                            <div class="card-header" style="height: 100px;">
                                <div class="d-block">
                                    <h4 class="text-dark">{{ $jdw->getNameMataKuliah($jdw->klkl_id) }}
                                        ({{ $jdw->klkl_id }})</h4>
                                    <p class="m-0">{{ $jdw->getNameProdi($jdw->prodi) }}</p>
                                </div>
                                <div class="card-header-action ml-auto">
                                    <a data-collapse="#{{ $jdw->klkl_id.$jdw->kelas }}" class="btn btn-icon btn-info"
                                        href="#"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="collapse" id="{{ $jdw->klkl_id.$jdw->kelas }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-between">
                                            <div>
                                                <b>Kelas</b>
                                                <p>{{ $jdw->kelas }}</p>
                                            </div>
                                            <div>
                                                <b>SKS</b>
                                                <p>{{ $jdw->sks }}</p>
                                            </div>
                                            <div>
                                                <b>Ruang</b>
                                                <p>{{ $jdw->ruang_id }}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                @if($instru->where('klkl_id', $jdw->klkl_id)->where('nik',
                                $jdw->kary_nik)->where('kelas',
                                $jdw->kelas)->first())

                                <button data-mk="{{ $jdw->klkl_id }}" data-nik="{{ $jdw->kary_nik }}"
                                    data-kelas="{{ $jdw->kelas }}" class="btn @if ($instru->where('klkl_id', $jdw->klkl_id)->where('nik',$jdw->kary_nik)->where('kelas', $jdw->kelas)->first())
                                    btn-primary @else btn-warning @endif btn-sm btnUbahNilai">
                                    Lihat Penilaian CLO
                                </button>

                                @else
                                <p class="text-warning">
                                    Instrumen Penilaian Belum Ada!
                                </p>
                                @endif

                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if($mkTdkLulus->isEmpty())
                    <div class="col-12">
                        <div class="alert alert-info">
                            Tidak ada data
                        </div>
                    </div>
                    @endif
                </div>
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>
@endsection
@push('script')
@include('instrumen-nilai.script')
@endpush
