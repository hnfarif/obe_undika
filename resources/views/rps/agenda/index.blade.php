@extends('layouts.main')
@section('rps', 'active')
@section('agenda', 'active')
@section('content')
<section class="section">
    @include('rps.section-header')

    <div class="section-body">
        {{-- <p class="section-lead">Masukkan data CLO </p> --}}
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 p-0 mb-2 d-flex">
                <a href="{{ route('kelola.agenda.create') }}" type="button"
                    class="btn btn-primary ml-3  align-self-center expanded"><i class="fas fa-plus"></i> Entri Agenda
                    Pembelajaran</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-12 p-0 d-flex">

                <div class="align-items-center pl-3">
                    <h2 class="section-title">Tabel Agenda Pembelajaran</h2>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Daftar Agenda Pembelajaran</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive" id="table" width="100%">
                            <thead>

                                <tr>
                                    <th rowspan="2">Minggu ke</th>
                                    <th rowspan="2">Kode CLO</th>
                                    <th rowspan="2">Kode LLO</th>
                                    <th rowspan="2">
                                        <div style="width: 150px">Deskripsi LLO</div>
                                    </th>
                                    <th rowspan="2">
                                        <div style="width: 150px">Ketercapaian LLO</div>
                                    </th>
                                    <th rowspan="2">Bentuk Penilaian</th>
                                    <th rowspan="2">
                                        <div style="width: 150px">Deskripsi Bentuk Penilaian</div>
                                    </th>
                                    <th rowspan="2">
                                        <div style="width: 150px">Materi</div>
                                    </th>
                                    <th rowspan="2">Metode</th>
                                    <th colspan="4">Kuliah (menit/mg)</th>
                                    <th rowspan="2">Responsi dan Tutorial (menit/mg)</th>
                                    <th rowspan="2">Belajar Mandiri (menit/mg)</th>
                                    <th rowspan="2">Praktikum (menit/mg)</th>
                                    <th rowspan="2">Aksi</th>

                                </tr>
                                <tr>
                                    <th>TM</th>
                                    <th>SL</th>
                                    <th>ASL</th>
                                    <th>ASM</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>

                                    <td>Minggu ke 1</td>
                                    <td>CLO-01</td>
                                    <td>LLO-01</td>
                                    <td>Mahasiswa mampu memahami konsep dasar manajemen dan analisis pada Big Data</td>
                                    <td>
                                        <p> 1. Mahasiswa memahami silabus, kontrak perkulihan, dan ruang lingkup
                                            perkuliahan Teknologi Big Data.</p>
                                        <p>

                                            2. Mahasiswa memahami konsep dasar Big Data
                                        </p>
                                    </td>
                                    <td>Menyampaikan pendapat (1%)
                                    </td>
                                    <td>
                                        <p>

                                            Menyampaikan pendapat tentang topik:
                                        </p>
                                        <p>

                                            - Pembentukan Big Data yang mungkin terjadi pada sebuah organisasi
                                        </p>
                                        <p>

                                            - Kelebihan dan Kelemahan Big Data
                                        </p>
                                        <p>

                                            - Permasalahan yang mungkin timbul dengan terbentuknya Big Data tersebut.
                                        </p>
                                    </td>
                                    <td>Bahan Kajian:
                                        Konsep dasar manajemen dan analisis pada Big Data
                                        Materi:
                                        - Pengantar perkuliahan Teknologi Big Data.
                                        - Konsep dasar analisis Big Data.
                                        - Dasar-dasar metode analis data
                                        - Wawasan industri saat ini terkait Big Data.
                                        - Karakteristik Big Data (konsep 5V’s : Volume, Velocity, Variety, Veracity,
                                        Value)
                                        Pustaka: U01, U04
                                        Media Pembelajaran: M01</td>
                                    <td>- Lecture
                                        - Discovery Learning
                                        - Discussion</td>
                                    <td>-</td>
                                    <td>60</td>
                                    <td>60</td>
                                    <td>30</td>
                                    <td>3x60</td>
                                    <td>3x60</td>
                                    <td>-</td>
                                    <td class="d-flex">
                                        <a href="#" class="btn btn-light mr-1 my-auto"><i class="fas fa-edit"></i>

                                        </a>
                                        <a href="#" class="btn btn-danger my-auto"><i class="fas fa-trash"></i>

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
