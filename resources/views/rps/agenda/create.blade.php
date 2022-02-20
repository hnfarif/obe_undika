@extends('layouts.main')
@section('rps', 'active')
@section('agenda', 'active')
@section('content')

<section class="section">
    @include('rps.section-header')
    <div class="section-body">
        <div class="row row-input">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Entri Agenda Pembelajaran</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Minggu ke</label>
                                    <input type="text" readonly class="form-control" value="Minggu ke 1">
                                </div>
                            </div>

                        </div>
                        <div class="section-title mt-0">Deskripsi Sub CLO (LLO)</div>
                        <div class="row">
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label>Kode CLO</label>
                                    <select class="form-control select2">
                                        <option>CLO-01 - Mahasiswa mampu menguraikan dan memilih aktivitas analisis Big
                                            Data yang sesuai
                                            dengan konteks masalah bisnis dalam organisasi.</option>
                                        <option>CLO-02 - Mampu membuat model deskripsi dan prediksi dengan mengambil
                                            potensi dari Big Data menggunakan metode-metode analitikal data sebagai
                                            dasar pengambilan keputusan yang sesuai dengan kebutuhan organisasi.
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kode LLO</label>
                                    <input type="text" class="form-control" value="LLO-02">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi LLO</label>
                                    <textarea name="" id="" style="height: 100px" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Ketercapaian LLO</label>

                                    <textarea class="form-control sn-capai"></textarea>

                                </div>

                                <div class="form-group">

                                    <button class="btn btn-primary">Tambah Sub CLO (LLO)</button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-striped table-responsive" id="table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Kode CLO</th>
                                                    <th>Kode LLO</th>
                                                    <th>Deskripsi</th>
                                                    <th>Ketercapaian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>CLO-01</td>
                                                    <td>LLO-01</td>
                                                    <td>Mahasiswa mampu memahami konsep dasar manajemen dan analisis
                                                        pada Big
                                                        Data</td>
                                                    <td>
                                                        <p>1. Mahasiswa memahami silabus, kontrak
                                                            perkulihan, dan ruang lingkup
                                                            perkuliahan Teknologi Big Data.</p>

                                                        <p>2. Mahasiswa memahami konsep dasar Big
                                                            Data</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="section-title mt-0">Bentuk Penilaian</div>
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="form-group">
                                    <label>Bentuk Penilaian</label>
                                    <select class="form-control select2">
                                        <option>Menyampaikan Pendapat</option>
                                        <option>Tugas Mandiri </option>
                                        <option>Tugas Kelompok</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">

                                <div class="form-group">
                                    <label>Bobot bentuk penilaian (%)</label>
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">

                                <div class="form-group">
                                    <label>Deskripsi Penilaian</label>
                                    <textarea name="" id="" style="height: 100px" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="section-title mt-0">Materi</div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Bahan Kajian</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Materi</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="" aria-label="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Pustaka</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Masukkan Judul"
                                            aria-label="">

                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Masukkan Bab"
                                            aria-label="">

                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Masukkan Halaman"
                                            aria-label="">

                                    </div>
                                    <button class="btn btn-primary" type="button">Tambah Pustaka</button>
                                </div>
                                <div class="form-group">
                                    <label>Media Pembelajaran</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="" aria-label="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Metode Pembelajaran</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="" aria-label="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Pengalaman Belajar Mahasiswa</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Kode PBM" aria-label=""
                                            value="B-01">
                                    </div>
                                    <div class="form-group mb-3">
                                        <textarea class="form-control sn-pbm"></textarea>
                                    </div>
                                    <button class="btn btn-primary" type="button">Tambah PBM</button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card ">
                                    <div class="card-header">
                                        <h4>Daftar Materi, Pustaka, dan Media Pembelajaran</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-wrapper" style="height: 600px;">
                                            <div id="accordion">
                                                <div class="accordion">
                                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                                        data-target="#materi" aria-expanded="true">
                                                        <h4>Materi</h4>
                                                    </div>
                                                    <div class="accordion-body collapse show" id="materi"
                                                        data-parent="#accordion">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Karakteristik Big Data (konsep 5V’s
                                                                        : Volume, Velocity, Variety, Veracity, Value)
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Pengantar perkuliahan Teknologi Big Data.
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Wawasan industri saat ini terkait Big Data.
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>

                                                        </ul>

                                                    </div>
                                                </div>
                                                <div class="accordion">
                                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                                        data-target="#pustaka">
                                                        <h4>Pustaka</h4>
                                                    </div>
                                                    <div class="accordion-body collapse" id="pustaka"
                                                        data-parent="#accordion">
                                                        <table class="table table-striped table-responsive" id="table"
                                                            width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Judul</th>
                                                                    <th>Bab</th>
                                                                    <th>Halaman</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Data Science and Big Data Analytics</td>
                                                                    <td>Bab 1-2</td>
                                                                    <td>59-60</td>
                                                                    <td class="d-flex">
                                                                        <a href="#" class="btn btn-light"
                                                                            style="height: 60%"><i
                                                                                class="fas fa-edit"></i>
                                                                        </a>

                                                                        <a href="#" class="btn btn-danger"
                                                                            style="height: 60%"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="accordion">
                                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                                        data-target="#medpem">
                                                        <h4>Media Pembelajaran</h4>
                                                    </div>
                                                    <div class="accordion-body collapse" id="medpem"
                                                        data-parent="#accordion">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Slide power point dari dosen
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Video dari youtube
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="accordion">
                                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                                        data-target="#metode">
                                                        <h4>Metode Pembelajaran</h4>
                                                    </div>
                                                    <div class="accordion-body collapse" id="metode"
                                                        data-parent="#accordion">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Lecture
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Discovery Learning
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Discussion
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="accordion">
                                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                                        data-target="#pbm">
                                                        <h4>Pengalaman Belajar Mahasiswa</h4>
                                                    </div>
                                                    <div class="accordion-body collapse" id="pbm"
                                                        data-parent="#accordion">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Mengerjakan tugas
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        melakukan survei
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        Menyusun paper
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#" class="btn btn-danger"><i
                                                                                class="fas fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-title mt-0">Perkuliahan</div>

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Tatap Muka (menit/mg)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Synchronous Learning (menit/mg)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Asynchronous Learning (menit/mg)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Assessment (menit/mg)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Responsi dan Tutorial (menit/mg)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Belajar Mandiri (menit/mg)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Praktikum (menit/mg)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary">Tambah Minggu ke 1</button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    $(document).ready(function () {

        $('.sn-capai').summernote({
            toolbar: [],

        });
        $('.sn-pbm').summernote({
            toolbar: [],
            inheritPlaceholder: true,
            placeholder: 'Masukkan Bentuk Pengalaman Kegiatan',
        });
    })

</script>
@endpush
