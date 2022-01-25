@extends('layouts.main')
@section('rps', 'active')
@section('wbm', 'active')
@section('content')
<section class="section">

    @include('rps.section-header')
    <div class="section-body">
        <div class="d-flex align-items-center my-0">
            <h2 class="section-title">Waktu Belajar Mahasiswa</h2>

        </div>
        {{-- <p class="section-lead">Masukkan, ubah data PEO </p> --}}

        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar WBM</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tr>
                                    <th>#</th>
                                    <th>Bentuk Pembelajaran</th>
                                    <th>Total Jam/Semester</th>
                                    <th>Rata-rata Jam/Minggu</th>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Synchronus Learning</td>
                                    <td>420 Menit = 7 jam (8 pertemuan)</td>
                                    <td>7 jam / 14 pertemuan = 0.5 jam</td>

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
