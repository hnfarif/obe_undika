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
                                    <th>Minggu ke</th>
                                    <th>Kode CLO</th>
                                    <th>Kode LLO</th>
                                    <th>Ketercapaian LLO</th>
                                    <th>Ketercapaian Bentuk Penilaian</th>
                                    <th>Deskripsi Penilaian</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr>

                                    <td>Minggu ke 1</td>
                                    <td>CLO-01</td>
                                    <td>LLO1</td>
                                    <td>Mahasiswa memahami silabus, kontrak perkulihan, dan ruang lingkup perkuliahan
                                    <td>Tugas Mandiri 4%</td>
                                    <td>Membuat skema / diagram tentang penguasaan fase-fase dalam daur hidup analisis
                                        Big Data dan alat yang digunakan dalam fase-fase tersebut sesuai dengan studi
                                        kasus pada perusahaan/organisasi.</td>
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
@section('script')


<script>
    $(document).ready(function () {
        // $('.expanded').on('click', function () {
        //     $('.row-input').removeAttr('hidden');
        //     $('.minimized').removeAttr('hidden');
        //     $('.expanded').attr('hidden', 'hidden');
        // })
        // $('.minimized').on('click', function () {
        //     $('.row-input').attr('hidden', 'hidden');
        //     $('.minimized').attr('hidden', 'hidden');
        //     $('.expanded').removeAttr('hidden');
        // })

    })

</script>
@endsection
