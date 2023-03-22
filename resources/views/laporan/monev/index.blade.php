@extends('layouts.main')
@section('laporan', 'active')
@section('monev', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            @include('laporan.section-header')
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
                                <input type="radio" name="optlaporan" value="monev" class="selectgroup-input"
                                    checked="">
                                <span class="selectgroup-button">Daftar Monev</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optlaporan" value="rangkuman" class="selectgroup-input">
                                <span class="selectgroup-button">Rangkuman</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row monev">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Monev</h4>
                                <a href="{{ route('laporan.exportExcel') }}" class="btn btn-success ml-auto mr-3"> <i
                                        class="fas fa-file-excel"></i> Export Excel </a>
                                <a target="_blank"
                                    href="{{ route('laporan.monev.exportPdf', ['fakultas' => request('fakultas'), 'prodi' => request('prodi'), 'dosen' => request('dosen') ]) }}"
                                    class="btn btn-danger mr-3">
                                    <i class="fas fa-file-pdf"></i> Export PDF </a>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#filterMonev">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="lapMonev" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2">
                                                    No
                                                </th>
                                                <th rowspan="2">Nama MK</th>
                                                <th rowspan="2">Kelas</th>
                                                <th rowspan="2">Nama Dosen</th>
                                                <th rowspan="2">Pemonev</th>
                                                @foreach ($kri as $k)
                                                @if ($loop->iteration <= 3) <th>{{ 'Kriteria '.$loop->iteration }}</th>
                                                    @endif
                                                    @endforeach
                                                    <th rowspan="2">Nilai Akhir</th>
                                            </tr>
                                            <tr>
                                                @foreach ($kri as $k)
                                                @if ($loop->iteration <= 3) <th>{{ $k->bobot.'%' }}</th>
                                                    @endif
                                                    @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataMonev as $dm)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $dm->getNameMataKuliah($dm->klkl_id) }}</td>
                                                <td>{{ $dm->kelas }}</td>
                                                <td>{{ $dm->karyawan->nama }}</td>
                                                <td>{{ $dm->dosenPemonev->nama }}</td>
                                                <td>{{ $dm->kri_1 }}</td>
                                                <td>{{ $dm->kri_2 }}</td>
                                                <td>{{ $dm->kri_3 }}</td>
                                                <td>{{ $dm->na }}</td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row rangkuman d-none">
                    <div class="section-title mt-0">Rata Angket Tiap Prodi</div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <canvas id="rata_prodi" width="700" height="200"></canvas>
                    </div>
                    <div class="section-title mt-5">Rata Angket Tiap Fakultas</div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <canvas id="rata_fak" width="700" height="200"></canvas>
                    </div>
                </div>

            </div>
        </section>
    </div>
    @include('layouts.footer')
</div>
@include('laporan.monev.modal-monev')
@endsection
@push('script')
@include('laporan.monev.script')
@endpush
