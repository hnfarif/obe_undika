@extends('layouts.main')
@section('rps', 'active')
@section('clo', 'active')
@section('content')
<section class="section">
    @include('rps.section-header')

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 p-0 mb-2 d-flex">
                <a href="{{ route('kelola.clo.create') }}" type="button"
                    class="btn btn-primary ml-3  align-self-center expanded"><i class="fas fa-plus"></i> Entri CLO</a>
            </div>
        </div>

        <div class="d-flex align-items-center my-0">
            <h2 class="section-title">Mata Kuliah</h2>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Deskripsi Mata Kuliah</label>
                                    <textarea name="" id="" style="height: 100px" class="form-control"
                                        readonly>Mata kuliah Teknologi Big Data membahas tentang Analisis Big Data beserta metode-metodenya.</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Mata Kuliah Prasyarat</label>
                                    <select class="form-control select2" multiple="">
                                        <option>Sistem Pendukung Keputusan</option>
                                        <option>Kualitas Data</option>
                                        <option>Teknologi Big Data</option>
                                    </select>
                                </div>
                                <div class="d-flex">
                                    <a href="#" class="btn btn-light mr-1"><i class="fas fa-edit"></i> Ubah</a>
                                    <a href="#" class="btn btn-success"><i class="fas fa-check"></i> Simpan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center my-0">
                <h2 class="section-title">Tabel CLO</h2>
            </div>
            {{-- <p class="section-lead">Masukkan data CLO </p> --}}
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar CLO</h4>
                        </div>
                        <div class="card-body">

                            <table class="table table-striped table-responsive" id="table">
                                <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>Kode PLO</th>
                                        <th>Kode CLO</th>
                                        <th>Deskripsi CLO</th>
                                        <th>Ranah Capaian Pembelajaran</th>
                                        <th>Level Bloom</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>PLO-01</td>
                                        <td>CLO-01</td>
                                        <td>Mahasiswa mampu menguraikan dan memilih aktivitas analisis Big Data yang
                                            sesuai
                                            dengan konteks masalah bisnis dalam organisasi.</td>
                                        <td>Kognitif, Psikomotorik, Afektif</td>
                                        <td>C4, P3, A3</td>
                                        <td class="d-flex">
                                            <a href="#" class="btn btn-light mr-1"><i class="fas fa-edit"></i>

                                            </a>
                                            <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i>

                                            </a>
                                        </td>
                                    </tr>
                                </tbody>


                            </table>


                        </div>
                    </div>

                </div>
            </div>
        </div>


</section>
@endsection
