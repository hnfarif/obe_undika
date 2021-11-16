@extends('layouts.main')
@section('peoplo', 'active')
@section('step1', 'active')
@section('content')
<section class="section">

    @include('kelolapeoplo.section-header')
    <div class="section-body">
        <div class="d-flex align-items-center my-0">
            <h2 class="section-title">Kelola PEO</h2>
            {{-- <a href="{{ route('peoplo.step2') }}" type="button" class="btn btn-primary ml-auto"><span>Selanjutnya
            </span> <i class="fas fa-chevron-right"></i></a> --}}
        </div>
        {{-- <p class="section-lead">Masukkan, ubah data PEO </p> --}}

        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Input PEO</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Kode PEO</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi PEO</label>
                            <textarea name="" id="" class="form-control" style="height: 100px"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary">Tambah PEO</button>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar PEO</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tr>
                                    <th>#</th>
                                    <th>Kode PEO</th>
                                    <th>Deskripsi PEO</th>
                                    <th>Aksi</th>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>PEO-01</td>
                                    <td>Menjadikan mahasiswa inovatif</td>
                                    <td><a href="#" class="btn btn-danger">Hapus</a></td>
                                </tr>

                            </table>
                        </div>
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1"><i
                                                class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1 <span
                                                class="sr-only">(current)</span></a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</section>
@endsection
