@extends('layouts.main')
@section('rps', 'active')
@section('llo', 'active')
@section('content')
<section class="section">
    @include('rps.section-header')

    <div class="section-body">
        {{-- <p class="section-lead">Masukkan data CLO </p> --}}
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 p-0 mb-2 d-flex">
                <button type="button" class="btn btn-primary ml-3  align-self-center expanded"><i
                        class="fas fa-plus"></i> Input LLO</button>
                <button type="button" class="btn btn-primary ml-3  align-self-center minimized" hidden="hidden"><i
                        class="fas fa-minus"></i> Input LLO</button>
            </div>
        </div>
        <div class="row row-input" hidden="hidden">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Input LLO</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Kode CLO</label>
                            <select class="form-control select2">
                                <option>CLO-01</option>
                                <option>CLO-02</option>
                                <option>CLO-03</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode LLO</label>
                            <input type="text" class="form-control" value="LLO-01" readonly>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi LLO</label>
                            <textarea name="" id="" style="height: 100px" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Ketercapaian CLO</label>
                            <div class="d-flex">
                                <textarea name="" id="" style="height: 100px" class="form-control"></textarea>
                                <button type="button" class="btn btn-primary ml-2 text-left d-flex align-self-center"
                                    style="height: 50%"><i class="fas fa-plus align-self-center mr-2"></i>Tambah
                                    Ketercapaian</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary">Tambah LLO</button>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Ketercapaian</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tr>
                                    <th>#</th>
                                    <th>Ketercapaian LLO</th>
                                    <th>Aksi</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Mahasiswa memahami silabus, kontrak perkulihan, dan ruang lingkup perkuliahan
                                        Teknologi Big Data</td>
                                    <td class="d-flex">
                                        <a href="#" class="btn btn-light mr-1"><i class="fas fa-edit"></i>

                                        </a>
                                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i>

                                        </a>
                                    </td>
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
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 p-0 d-flex">

                <div class="align-items-center pl-3">
                    <h2 class="section-title">Tabel LLO</h2>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Daftar LLO</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive" width="100%">

                            <tr>
                                <th>#</th>
                                <th>Kode LLO</th>
                                <th>Kode CLO</th>
                                <th>Ketercapaian CLO</th>
                            </tr>

                            <tr>
                                <td>1</td>
                                <td>LLO1</td>
                                <td>CLO-01</td>
                                <td>Mahasiswa memahami silabus, kontrak perkulihan, dan ruang lingkup
                                    perkuliahan Teknologi Big Data
                                </td>
                            </tr>

                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('.expanded').on('click', function () {
            $('.row-input').removeAttr('hidden');
            $('.minimized').removeAttr('hidden');
            $('.expanded').attr('hidden', 'hidden');
        })
        $('.minimized').on('click', function () {
            $('.row-input').attr('hidden', 'hidden');
            $('.minimized').attr('hidden', 'hidden');
            $('.expanded').removeAttr('hidden');
        })
    })

</script>
@endsection
