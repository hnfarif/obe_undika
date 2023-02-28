@extends('layouts.main')
@section('laporan', 'active')
@section('angket', 'active')
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
                                <input type="radio" name="optlaporan" value="angket" class="selectgroup-input"
                                    checked="">
                                <span class="selectgroup-button">Daftar Angket</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="optlaporan" value="rangkuman" class="selectgroup-input">
                                <span class="selectgroup-button">Rangkuman</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row angket">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Angket</h4>

                                <a target="_blank"
                                    href="{{ route('laporan.angket.exportPdf', ['fakultas' => request('fakultas'), 'prodi' => request('prodi'), 'dosen' => request('dosen') ]) }}"
                                    class="btn btn-danger ml-auto mr-3">
                                    <i class="fas fa-file-pdf"></i> Export PDF </a>
                                <button class="btn btn-primary " data-toggle="modal" data-target="#filterAngket">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="lapAngket" width="100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>NIK</th>
                                            <th>Nama Dosen</th>
                                            <th>Nama MK dan rata-rata</th>
                                            <th>Rata-rata Dosen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($angket as $key => $a)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{ $a[0]->karyawan->nama }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($a->unique('kode_mk') as $keymk => $mk)
                                                    <li>
                                                        {{ $mk->matakuliah->nama.' ('. $mk->kode_mk.') '. $mk->kelas. ' : '. number_format($a->where('kode_mk', $mk->kode_mk)->avg('nilai'), 2)
                                                    }}
                                                    </li>
                                                    @endforeach
                                                </ul>

                                            </td>

                                            <td>
                                                {{ number_format($a->avg('nilai'), 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
@include('laporan.angket.modal-angket')
@endsection
@push('script')
@include('laporan.angket.script')
@endpush
