@extends('layouts.main')
@section('peoplo', 'active')
@section('step3', 'active')
@section('content')
<section class="section">
    @include('rps.section-header')

    <div class="section-body">
        <div class="d-flex align-items-center my-0">
            <h2 class="section-title">Hasil Mapping</h2>
            {{-- <a href="{{ route('peoplo.step3') }}" type="button" class="btn btn-primary ml-auto"><i
                class="fas fa-check-circle"></i><span> Simpan Data PEO-PLO
            </span> </a> --}}
        </div>
        {{-- <p class="section-lead">Hasil Input dan Mapping PEO-PLO</p> --}}

        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Mapping PEO-PLO</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tr>
                                    <th>#</th>
                                    <th>Kode PEO</th>
                                    <th>Deskripsi PEO</th>
                                    <th>Kode PLO</th>
                                    <th>Deskripsi PLO</th>
                                    <th>Aksi</th>

                                </tr>
                                <tr>
                                    <td rowspan="2">1</td>
                                    <td rowspan="2">PEO-01</td>
                                    <td rowspan="2">Menghasilkan lulusan profesional sebagai Pengembang Sistem Informasi
                                        yang didukung oleh Kemampuan Analisis Data untuk Menghasilkan Realtime SPK dan
                                        mampu memberikan solusi sebagai Konsultan IT di suatu Organisasi</td>
                                    <td>PLO-01</td>
                                    <td>Mampu mengidentifikasi, memformulasikan dan memecahkan permasalahan kebutuhan
                                        informasi dari sebuah organisasi</td>
                                    <td><a href="#" class="btn btn-danger">Hapus</a></td>
                                </tr>
                                <tr>
                                    <td>PLO-02</td>
                                    <td>Dapat mengintegrasikan solusi berbasis teknologi informasi secara efektif pada
                                        suatu organisasi</td>
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
