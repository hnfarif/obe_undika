@extends('layouts.main')
@section('instrumen-nilai', 'active')
@section('', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                @include('instrumen-nilai.breadcrumb')
                <div class="row insTdkTercapai">

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
                                                <th>Jumlah MK tidak tercapai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($mkTdkLulus->unique('kary_nik') as $k)

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
                                                    {{ $mkTdkLulus->where('kary_nik', $k->kary_nik)->count() }}
                                                </td>

                                                <td>
                                                    <a href="#" class="btn btn-primary btn-sm text-sm">Detail</a>
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
@endsection
@push('script')
@include('instrumen-nilai.script')
@endpush
