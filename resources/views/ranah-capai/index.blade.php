@extends('layouts.main')
@section('ranahcapai', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Ranah Capaian</h4>
                                <div class="card-header-action">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#imporData">
                                        <i class="fas fa-file-excel"></i> Tambah Ranah Capaian
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    Kode
                                                </th>
                                                <th>Nama Ranah Capaian</th>
                                                <th>Inisial</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>tes</td>
                                                <td>tes</td>
                                                <td>tes</td>
                                                <td>tes</td>
                                            </tr>
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
@include('ranah-capai.modal')
@endsection
@push('script')

@endpush
