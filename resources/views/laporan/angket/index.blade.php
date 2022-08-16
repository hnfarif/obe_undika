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

                <div class="row monev">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Monev</h4>
                                <button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#filterMonev">
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

                                                <th rowspan="2">Nilai Akhir</th>
                                            </tr>
                                            <tr>

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
{{-- @include('laporan.angket.modal-monev') --}}
@endsection
@push('script')
{{-- @include('laporan.angket.script') --}}
@endpush
